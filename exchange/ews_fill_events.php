<?php
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include($rootpath.'\\lib\\ews.php');
include($rootpath.'\\template_rapport\\lib\\file_management.php');
include($rootpath.'\\config\\config_ews.php');
include($rootpath.'\\includes\\php_linguistique.php');

$id_cal = '';
if (isset($_POST['id_cal']))
 $id_cal = trim($_POST['id_cal']);
if (($id_cal == '') || ($id_cal == null))
 $id_cal = '';

$id_obj = '';
if (isset($_POST['id_obj']))
 $id_obj = trim($_POST['id_obj']);
if (($id_obj == '') || ($id_obj == null))
 $id_obj = '';
 
$workday = '';
if (isset($_POST['workday']))
 $workday = trim($_POST['workday']);
if (($workday == '') || ($workday == null) || ($workday != true) || ($workday != 1))
 $workday = false;
else
 $workday = true;

$working_days='';
if (isset($_POST['working_days']))
 $working_days = trim($_POST['working_days']);
if (($working_days == '') || ($working_days == null) || ($working_days < 1) || (is_numeric($working_days) == false))
 $working_days = 5;
else
 $working_days = (($working_days <> 5) && ($working_days <> 7)) ? 5 : $working_days;

$username = "";
if (isset($_POST['username']))
 $username = trim($_POST['username']);
if (($username == '') || ($username == null))
 $username = '';

$email_psw = "";
if (isset($_POST['password']))
 $email_psw = trim($_POST['password']);
if (($email_psw == '') || ($email_psw == null))
 $email_psw = '';

if ($username == 'agenda_off')
{
 $as_email = $email_array['agenda_off'];

 if (isset($as_email['email']))
  $username = trim($as_email['email']);
 else
  $username = '';

 if (isset($as_email['email_psw']))
  $password = trim($as_email['email_psw']);
 else
  $password = ''; 
 $email_psw = $password;
}
else
{
 $password = trim(base64_decode($email_psw));
 if ((trim($password) == '') || ($password == null))
  $password = '';
}

$param_direction = '';
if (isset($_POST['param_direction']))
 $param_direction = trim($_POST['param_direction']);
if (($param_direction == '') || ($param_direction == null))
 $param_direction = '';

$param_date = '';
if (isset($_POST['param_date']))
 $param_date = trim($_POST['param_date']);
if (($param_date == '') || ($param_date == null) || ($param_date == '0000-00-00') || ($param_date == '00-00-0000'))
 $param_date = '';

$param_date_to = '';
if (isset($_POST['param_date_to']))
 $param_date_to = trim($_POST['param_date_to']);
if (($param_date_to == '') || ($param_date_to == null) || ($param_date_to == '0000-00-00') || ($param_date_to == '00-00-0000'))
 $param_date_to = '';
 
if ($param_direction == 's')
 $param_date = date('Y-m-d');

$code_langue = '';
if (isset($_POST['code_langue']))
 $code_langue = trim($_POST['code_langue']);
else
{
 if (isset($_GET['code_langue']))
  $code_langue = trim($_GET['code_langue']);
}
if ((trim($code_langue) == '') || ($code_langue == null) || (isset($array_linguistique[$code_langue]) != true))
 $code_langue = 'F';

if (($param_direction == '') || ($param_direction == null))
{
 ob_clean();
 header('Content-Type: text/html; charset=utf-8');
 echo '<undefined>';
 echo '<javascript>';
 echo '<undefined>';
 exit;
}
 
if (($param_date == '') || ($param_date == null) || ($param_date == '0000-00-00') || ($param_date == '00-00-0000'))
{
 ob_clean();
 header('Content-Type: text/html; charset=utf-8');
 echo '<undefined>';
 echo '<javascript>';
 echo '<undefined>';
 exit;
}

if (($param_direction == 'd') && (($param_date_to == '') || ($param_date_to == null) || ($param_date_to == '0000-00-00') || ($param_date_to == '00-00-0000')))
{
 ob_clean();
 header('Content-Type: text/html; charset=utf-8');
 echo '<undefined>';
 echo '<javascript>';
 echo '<undefined>';
 exit;
}

if (($username == '') || ($username == null) || (trim($email_psw) == '') || ($email_psw == null) || (trim($password) == '') || ($password == null))
{
 ob_clean();
 header('Content-Type: text/html; charset=utf-8');
 echo '<undefined>';
 echo '<javascript>';
 echo '<undefined>';
 exit;
}
  
ob_clean();
header('Content-Type: text/html; charset=utf-8');
$start_date = '';
$end_date = '';

$a_date = explode('-', $param_date);
$year_temp = intval($a_date[0]);
$month_temp = intval($a_date[1]);
$day_temp = intval($a_date[2]);

switch ($param_direction)
{
 case 's':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, 1, $year_temp);
  $month_temp++;
  $tempto_date = mktime(0, 0, 0, $month_temp, 0, $year_temp);
  break;
 case '+':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, $day_temp+1, $year_temp);
  $temp_date = date('d-m-Y', $tempfrom_date);
  $a_date = explode('-', $temp_date);
  $temp_month = intval($a_date[1]);
  if ($temp_month > $month_temp)
   $month_temp=$temp_month;
  $month_temp++;
  
  $tempto_date = mktime(0, 0, 0, $month_temp, 0, $year_temp);
  break;
 case '-':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, $day_temp-1, $year_temp);
  
  $param_date = date('d-m-Y',$tempfrom_date);
  $a_date = explode('-', $param_date);
  $day_temp = intval($a_date[0]);
  $month_temp = intval($a_date[1]);
  $year_temp = intval($a_date[2]);
  $tempto_date = mktime(0, 0, 0, $month_temp+1, 0, $year_temp);
  break;
 case 'd':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, $day_temp, $year_temp);
  $a_date = explode('-', $param_date_to);
  $year_temp = intval($a_date[0]);
  $month_temp = intval($a_date[1]);
  $day_temp = intval($a_date[2]);

  $tempto_date = mktime(0, 0, 0, $month_temp, $day_temp, $year_temp);
  $workday = false;
  break;
 default:
  ob_clean();
  header('Content-Type: text/html; charset=utf-8');
  echo '<undefined>';
  echo '<javascript>';
  echo '<undefined>';
  exit;
}
$start_date = date('d-m-Y', $tempfrom_date);
$end_date = date('d-m-Y', $tempto_date);

$a_date = explode('-', $start_date);
$day_temp = intval($a_date[0]);
$month_temp = intval($a_date[1]);
$year_temp = intval($a_date[2]);

$a_rdv = array();
if ($param_direction == 'd')
 $a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
else
{
 if ($workday == true)
 {
  $temp_date = mktime(0, 0, 0, $month_temp, $day_temp,$year_temp);
  $nd_day = date('N',$temp_date);

  $temp_fromdate = mktime(0, 0, 0, $month_temp, $day_temp-($nd_day-1), $year_temp);
  $start_date = date('d-m-Y',$temp_fromdate);
 
  $temp_todate = mktime(0, 0, 0, $month_temp, $day_temp+(7-$nd_day), $year_temp);
  $end_date = date('d-m-Y',$temp_todate);
  
  $a_rdv = GetEwsWorkingWeekListItems($username,$password,$start_date,$working_days,'');
 }
 else
 {
  $temp_date = mktime(0, 0, 0, $month_temp, $day_temp, $year_temp);
  $nd_day = date('N',$temp_date);

  $temp_fromdate = mktime(0, 0, 0, $month_temp, $day_temp-($nd_day-1), $year_temp);
  $start_date = date('d-m-Y',$temp_fromdate);

  $a_date = explode('-', $end_date);
  $day_temp = intval($a_date[0]);
  $month_temp = intval($a_date[1]);
  $year_temp = intval($a_date[2]);

  $temp_date = mktime(0, 0, 0, $month_temp, $day_temp, $year_temp);
  $nd_day = date('N',$temp_date);

  $temp_todate = mktime(0, 0, 0, $month_temp, $day_temp+(7-$nd_day), $year_temp);
  $end_date = date('d-m-Y',$temp_todate);

  $a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,'');
 }
}

$events = '';
foreach ($a_rdv as $key => $aevent)
{
 $start_exdate = addslashes($aevent['LOCAL_DEBUT']); // => 2012-03-05T08:00:00Z
 $end_exdate = addslashes($aevent['LOCAL_FIN']); // => 2012-03-05T14:30:00Z
 
 $titel = trim(addslashes($aevent['SUJET']));
 //$titel .= (trim($aevent['OU']) != '') ? trim($aevent['OU']) : '';
 $id_event = $aevent['ID'];
 $change_event = $aevent['CHANGEKEY'];
 $events .= "fFillEvent($id_obj,'$id_cal','$id_event','$change_event', '$titel', '$start_exdate', '$end_exdate');";
}

$javascript = '';
if (($events != '') && ($events != null))
{
 $javascript = "$(function() {";
 $javascript .= $events;
 $javascript .= "});";
}
switch ($param_direction)
{
 case 's':
  $javascript .= "document.CALENDAR_FORM.date_from.value='".date('Y-m-d',$temp_fromdate)."';";
  $javascript .= "document.CALENDAR_FORM.date_to.value='".date('Y-m-d',$temp_todate)."';";
  break;
 case '+':
  $javascript .= "document.CALENDAR_FORM.date_to.value='".date('Y-m-d',$temp_todate)."';";
  break;
 case '-':
  $javascript .= "document.CALENDAR_FORM.date_from.value='".date('Y-m-d',$temp_fromdate)."';";
  break;
 case 'd':
  break;
 default:
  $javascript .= "document.CALENDAR_FORM.date_from.value='".date('Y-m-d',$temp_fromdate)."';";
  $javascript .= "document.CALENDAR_FORM.date_to.value='".date('Y-m-d',$temp_todate)."';";
  break;
}

ob_clean();
header('Content-Type: text/html; charset=utf-8');
echo '<undefined>';
if ($javascript != '')
{
 echo '<javascript>';
 echo $javascript;
}

exit;
?>