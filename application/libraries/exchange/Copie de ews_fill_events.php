<?php
// Calendrier évenement - étude
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include('ews.php');

$id_cal = '';
if (isset($_POST['id_cal']))
 $id_cal = trim($_POST['id_cal']);
if (($id_cal == '') || ($id_cal == null))
 $id_cal = '';

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

$password = "";
if (isset($_POST['password']))
 $password = trim($_POST['password']);
if (($password == '') || ($password == null))
 $password = '';

$param_date = '';
if (isset($_POST['param_date']))
 $param_date = trim($_POST['param_date']);
if (($param_date == '') || ($param_date == null) || ($param_date == '0000-00-00') || ($param_date == '00-00-0000'))
 $param_date = date('d-m-Y');

$a_date = explode('-', $param_date);
$day_temp = intval($a_date[0]);
$month_temp = intval($a_date[1]);
$year_temp = intval($a_date[2]);
  
$param_direction = '';
if (isset($_POST['param_direction']))
 $param_direction = trim($_POST['param_direction']);
if (($param_direction == '') || ($param_direction == null))
 $param_direction = '';

if ($end_date == '')
 $workday = true;

$code_langue = '';
if (isset($_POST['code_langue']))
 $code_langue = trim($_POST['code_langue']);
if (($code_langue == '') || ($code_langue == null))
 $code_langue = 'F';

$code_langue = "N";

if (($param_date == '') || ($param_date == null) || ($param_date == '0000-00-00') || ($param_date == '00-00-0000'))
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
echo '<undefined>';
echo '<javascript>';
$start_date = '';
$end_date = '';
echo "alert('$param_direction / $param_date - $start_date - $end_date');";

switch ($param_direction)
{
 case 's':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, 1, $year_temp);
  $month_temp++;
  $tempto_date = mktime(0, 0, 0, $month_temp, 0, $year_temp);
  break;
 case '+':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, $day_temp+1, $year_temp);
  $month_temp++;
  $tempto_date = mktime(0, 0, 0, $month_temp, 0, $year_temp);
  break;
 case '-':
  $tempfrom_date = mktime(0, 0, 0, $month_temp, $day_temp-1, $year_temp);
  $param_date = date('d-m-Y', $tempfrom_date);
  $a_date = explode('-', $param_date);
  $day_temp = intval($a_date[0]);
  $month_temp = intval($a_date[1]);
  $year_temp = intval($a_date[2]);

  $tempto_date = mktime(0, 0, 0, $month_temp, 1, $year_temp);
  break;
 default:
  //ob_clean();
  //header('Content-Type: text/html; charset=utf-8');
  //echo '<undefined>';
  //echo '<javascript>';
  //echo '<undefined>';
  //exit;
}
$start_date = date('d-m-Y', $tempfrom_date);
$end_date = date('d-m-Y', $tempto_date);

//echo "alert('$param_direction / $param_date - $start_date - $end_date - $temp_date $temp2_date');";
//$temp = $temp2_date-$temp_date;
//echo "alert('$temp');";
//exit;
$a_date = explode('-', $start_date);
$day_temp = intval($a_date[0]);
$month_temp = intval($a_date[1]);
$year_temp = intval($a_date[2]);
 
$a_rdv = array();
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

$events = '';
foreach ($a_rdv as $key => $aevent)
{
 $start_exdate = $aevent['EXCHANGE_DEBUT']; // => 2012-03-05T08:00:00Z
 $end_exdate = $aevent['EXCHANGE_FIN']; // => 2012-03-05T14:30:00Z
 $end_exdate = $temp_string;
 
 $titel = trim(addslashes($aevent['SUJET']));
 //$titel .= (trim($aevent['OU']) != '') ? trim($aevent['OU']) : '';

 $events .= "$('#$id_cal').fullCalendar('renderEvent',";
 $events .= '{';
 $events .= "id:'".$aevent['ID'].'||'.$aevent['CHANGEKEY']."',";
 $events .= "title:'$titel',";
 $events .= "start: '$start_exdate',";
 $events .= "end: '$end_exdate',";
 //$events .= "color:'yellow',";
 //$events .= "textColor:'black',";

 //backgroundColor
 //borderColor
 $events .= "allDay:false";
 //$events .= "url: 'http://google.com/'";
 $events .= '},true);';
}

$javascript = "$(function() {";
$javascript .= $events;
$javascript .= "});";
$javascript .= "document.CALENDAR_FORM.date_from.value='".date('d-m-Y',$temp_fromdate)."';";
$javascript .= "document.CALENDAR_FORM.date_to.value='".date('d-m-Y',$temp_todate)."';";

ob_clean();
header('Content-Type: text/html; charset=utf-8');
echo '<undefined>';
echo '<javascript>';
echo $javascript;
exit;
?>


