<?php
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"].'\\lib\\ews.php');
include('array_lbl_cal.php');

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

$start_date = '';
if (isset($_POST['start_date']))
 $start_date = trim($_POST['start_date']);
if (($start_date == '') || ($start_date == null) || ($start_date == '0000-00-00') || ($start_date == '00-00-0000'))
 $start_date = date('d-m-Y');

$end_date = '';
if (isset($_POST['end_date']))
 $end_date = trim($_POST['end_date']);
if (($end_date == '') || ($end_date == null) || ($end_date == '0000-00-00') || ($end_date == '00-00-0000'))
 $end_date = '';

if ($end_date == '')
 $workday = true;

$code_langue = '';
if (isset($_POST['code_langue']))
 $code_langue = trim($_POST['code_langue']);
if (($code_langue == '') || ($code_langue == null))
 $code_langue = 'F';

$code_langue = "N";

$a_rdv = array();
if ($workday == true)
{
 $a_date = explode('-', $start_date);
 $temp_date = mktime(0, 0, 0, $a_date[1], $a_date[0], $a_date[2]);
 $nd_day = date('N',$temp_date);

 $temp_fromdate = mktime(0, 0, 0, $a_date[1], $a_date[0]-($nd_day-1), $a_date[2]);
 $start_date = date('d-m-Y',$temp_fromdate);
 
 $temp_todate = mktime(0, 0, 0, $a_date[1], $a_date[0]+(7-$nd_day), $a_date[2]);
 $end_date = date('d-m-Y',$temp_todate);

 $a_rdv = GetEwsWorkingWeekListItems($username,$password,$start_date,$working_days,'');
}
else
{
 $a_date = explode('-', $start_date);
 $temp_date = mktime(0, 0, 0, $a_date[1], $a_date[0], $a_date[2]);
 $nd_day = date('N',$temp_date);

 $temp_fromdate = mktime(0, 0, 0, $a_date[1], $a_date[0]-($nd_day-1), $a_date[2]);
 $start_date = date('d-m-Y',$temp_fromdate);

 $a_date = explode('-', $end_date);
 $temp_date = mktime(0, 0, 0, $a_date[1], $a_date[0], $a_date[2]);
 $nd_day = date('N',$temp_date);
 
 $temp_todate = mktime(0, 0, 0, $a_date[1], $a_date[0]+(7-$nd_day), $a_date[2]);
 $end_date = date('d-m-Y',$temp_todate);

 $a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
}

$javascript = "$(function() {";
$javascript .= "$('#$id_cal').fullCalendar({";
$javascript .= "header: {";
  //left: 'prev,next today',
$javascript .= "left: '',";
$javascript .= "center: 'title',";
$javascript .= "right: 'month,agendaWeek,agendaDay'";
$javascript .= "},";
$javascript .= "columnFormat:";
$javascript .= "{";
$javascript .= "month: 'dddd',";
$javascript .= "week: 'dddd<br/>dd/MM/yyyy',";
$javascript .= "day: 'dddd<br/>dd/MM/yyyy'";
$javascript .= "},";
$javascript .= "buttonText:";
$javascript .= "{";
//  prev:     '&nbsp;&#9668;&nbsp;',
//  next:     '&nbsp;&#9658;&nbsp;',
 //echo "today:'".addslashes($array_lbl['TODAY'][$code_langue])."',\n";
$javascript .= "month:'".addslashes($array_lbl['MONTHLY'][$code_langue])."',";
$javascript .= "week:'".addslashes($array_lbl['WEEKLY'][$code_langue])."',";
$javascript .="day:'".addslashes($array_lbl['DAILY'][$code_langue])."'";
$javascript .= "},";
$javascript .= "allDaySlot:false,";
 //allDayText:'Toute la journée',
$javascript .= "defaultView:'agendaWeek',";
$javascript .= "axisFormat:'HH:mm',";
$javascript .= "agenda:'HH:mm{ - HH:mm}',";
$javascript .= "timeFormat:'HH:mm{ - HH:mm}',";
$javascript .= "firstDay:1,";
$javascript .= "slotMinutes:30,";
$javascript .= "defaultEventMinutes:30,";
$javascript .= "firstHour:'7:30',";
$javascript .= "minTime:'7:30',";
$javascript .= "LastHour:'17:30',";
$javascript .= "maxTime:'17:30',";
$javascript .= "weekMode:'liquid',";
$javascript .= "weekends:false,";
$javascript .= "editable:false,";
 //ignoreTimezone:true,
// height:350,
$temp_string = '';
$temparray = $array_weekday[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$javascript .= "dayNames:[$temp_string],";

$temp_string = '';
$temparray = $array_short_weekday[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$javascript .= "dayNamesShort:[$temp_string],";

$temp_string = '';
$temparray = $array_month[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$javascript .= "monthNames:[$temp_string],";

$temp_string = '';
$temparray = $array_short_month[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$javascript .= "monthAbbrevs:[$temp_string],";

$events = '';
foreach ($a_rdv as $key => $aevent)
{
 $start_date = $aevent['START_DATE']; // => 01/03/2012
 $start_heure = $aevent['START_HEURE']; // => 08:00
 
 $adate = explode('/', $start_date);
 $d_start = $adate[0];
 $m_start = ($adate[1]*1)-1;
 $y_start = $adate[2];

 $adate = explode(':', $start_heure);
 $mi_start = $adate[0];
 $h_start = $adate[1];

 $end_date = $aevent['END_DATE']; // => 01/03/2012
 $end_heure = $aevent['END_HEURE']; // => 09:00

 $adate = explode('/', $start_date);
 $d_end = $adate[0];
 $m_end = ($adate[1]*1)-1;
 $y_end = $adate[2];

 $adate = explode(':', $end_heure);
 $mi_end = $adate[0];
 $h_end = $adate[1];
 
 $from_string = array('T', 'Z');
 $to_string   = array(' ', '');

 $temp_string = $aevent['EXCHANGE_DEBUT']; // => 2012-03-05T08:00:00Z
 $start_exdate = str_replace($from_string, $to_string, $temp_string);
 
 $temp_string = $aevent['EXCHANGE_FIN']; // => 2012-03-05T14:30:00Z
 $end_exdate = str_replace($from_string, $to_string, $temp_string);
 
 $titel = trim(addslashes($aevent['SUJET']));
 //$titel .= (trim($aevent['OU']) != '') ? trim($aevent['OU']) : '';

 $events .= ($events != '') ? ',' : '';
 $events .= '{';
 $events .= "id:'".$aevent['ID'].'||'.$aevent['CHANGEKEY']."',";
 $events .= "title:'$titel',";
// $events .= "start: new Date($y_start,$m_start,$d_start),";
// $events .= "end: new Date($y_end,$m_end,$d_end),";
 $events .= "start: '$start_exdate',";
 $events .= "end: '$end_exdate',";
// $events .= "color:'yellow',";
// $events .= "textColor:'black',";

// backgroundColor
// borderColor
 $events .= "allDay:false";
 //$events .= "url: 'http://google.com/'";
 $events .= '}';
}
$javascript .= "events:[".$events."],";

$javascript .= "eventClick: function(calEvent, jsEvent, view)";
$javascript .= "{";
$javascript .= "var v_ThisDate = new Date(calEvent.start);";
$javascript .= "var vn_day = v_ThisDate.getDate();";
$javascript .= "var vn_month = v_ThisDate.getMonth();";
$javascript .= "var vn_year = v_ThisDate.getFullYear();";
$javascript .= "var vn_hour = v_ThisDate.getHours();";
$javascript .= "var vn_min = v_ThisDate.getMinutes();";
$javascript .= "$('#$id_cal').fullCalendar( 'gotoDate', vn_year, vn_month, vn_day);";
$javascript .= "alert(document.CALENDAR_FORM.date_from.value);";
$javascript .= "alert(document.CALENDAR_FORM.date_to.value);";
 //alert('Event: ' + calEvent.start +'-'+ calEvent.end + '-' + calEvent.title+' '+ calEvent.id);
 //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
 //alert('View: ' + view.name);

 // change the border color just for fun
$javascript .= "$(this).css('borderColor', 'red');";
$javascript .= "}";
$javascript .= "});";
$javascript .= "$('.cal_button').mouseover(function()";
$javascript .= "{";
$javascript .= "$(this).addClass('fc-state-hover');";
$javascript .= "$(this).removeClass('fc-state-default');";
$javascript .= "});";
$javascript .= "$('.cal_button').mouseout(function()";
$javascript .= "{";
$javascript .= "$(this).removeClass('fc-state-hover');";
$javascript .= "$(this).addClass('fc-state-default');";
$javascript .= "});";

$javascript .= "$('#prev_cal').click(function()";
$javascript .= "{";
$javascript .= "var d = $('#$id_cal').fullCalendar('getDate');";
$javascript .= "$('#$id_cal').fullCalendar('prev');";
$javascript .= "var vs_view = $('#$id_cal').fullCalendar('getView').name;";

$javascript .= "var v_ThisDate = new Date($('#$id_cal').fullCalendar('getView').visStart);";
$javascript .= "var vn_day_start = v_ThisDate.getDate();";
$javascript .= "var vn_month_start = v_ThisDate.getMonth()+1;";
$javascript .= "var vn_year_start = v_ThisDate.getFullYear();";
$javascript .= "var vn_hour_start = v_ThisDate.getHours();";
$javascript .= "var vn_min_start = v_ThisDate.getMinutes();";
$javascript .= "var vs_month_start = (vn_month_start < 10) ? '0'+vn_month_start : vn_month_start;";
$javascript .= "var vs_day_start = (vn_day_start < 10) ? '0'+vn_day_start : vn_day_start;";
$javascript .= "var vs_date_start = vn_year_start+'-'+vs_month_start+'-'+vs_day_start;";

//$javascript .= "alert($('#$id_cal').fullCalendar('getView').visStart+' '+document.CALENDAR_FORM.date_from.value+' '+vs_date_start);";

$javascript .= "var v_ThisDate = new Date($('#$id_cal').fullCalendar('getView').visEnd);";
$javascript .= "var vn_day_end = v_ThisDate.getDate();";
$javascript .= "var vn_month_end = v_ThisDate.getMonth()+1;";
$javascript .= "var vn_year_end = v_ThisDate.getFullYear();";
$javascript .= "var vn_hour_end = v_ThisDate.getHours();";
$javascript .= "var vn_min_end = v_ThisDate.getMinutes();";
$javascript .= "var vs_month_end = (vn_month_end < 10) ? '0'+vn_month_end : vn_month_end;";
$javascript .= "var vs_day_end = (vn_day_end < 10) ? '0'+vn_day_end : vn_day_end;";
$javascript .= "var vs_date_end = vn_year_end+'-'+vs_month_end+'-'+vs_day_end;";

//$javascript .= "alert($('#$id_cal').fullCalendar('getView').visEnd+' '+document.CALENDAR_FORM.date_to.value+' '+vs_date_end);";
$javascript .= "if (vs_date_start < document.CALENDAR_FORM.date_from.value)";
$javascript .= " fDisplayEvents(document.CALENDAR_FORM.date_from.value, '-');";
$javascript .= "});";

$javascript .= "$('#next_cal').click(function()";
$javascript .= "{";
$javascript .= "var d = $('#$id_cal').fullCalendar('getDate');";
 //alert($('#calendar').fullCalendar('getView').name+' '+d);
$javascript .= "var vs_view = $('#$id_cal').fullCalendar('getView').name;";
$javascript .= "$('#$id_cal').fullCalendar('next');";

$javascript .= "var v_ThisDate = new Date($('#$id_cal').fullCalendar('getView').visStart);";
$javascript .= "var vn_day_start = v_ThisDate.getDate();";
$javascript .= "var vn_month_start = v_ThisDate.getMonth()+1;";
$javascript .= "var vn_year_start = v_ThisDate.getFullYear();";
$javascript .= "var vn_hour_start = v_ThisDate.getHours();";
$javascript .= "var vn_min_start = v_ThisDate.getMinutes();";
$javascript .= "var vs_month_start = (vn_month_start < 10) ? '0'+vn_month_start : vn_month_start;";
$javascript .= "var vs_day_start = (vn_day_start < 10) ? '0'+vn_day_start : vn_day_start;";
$javascript .= "var vs_date_start = vn_year_start+'-'+vs_month_start+'-'+vs_day_start;";

//$javascript .= "alert($('#$id_cal').fullCalendar('getView').visStart+' '+document.CALENDAR_FORM.date_from.value+' '+vs_date_start);";

$javascript .= "var v_ThisDate = new Date($('#$id_cal').fullCalendar('getView').visEnd);";
$javascript .= "var vn_day_end = v_ThisDate.getDate();";
$javascript .= "var vn_month_end = v_ThisDate.getMonth()+1;";
$javascript .= "var vn_year_end = v_ThisDate.getFullYear();";
$javascript .= "var vn_hour_end = v_ThisDate.getHours();";
$javascript .= "var vn_min_end = v_ThisDate.getMinutes();";
$javascript .= "var vs_month_end = (vn_month_end < 10) ? '0'+vn_month_end : vn_month_end;";
$javascript .= "var vs_day_end = (vn_day_end < 10) ? '0'+vn_day_end : vn_day_end;";
$javascript .= "var vs_date_end = vn_year_end+'-'+vs_month_end+'-'+vs_day_end;";

//$javascript .= "alert($('#$id_cal').fullCalendar('getView').visEnd+' '+document.CALENDAR_FORM.date_to.value+' '+vs_date_end);";

$javascript .= "if (vs_date_start > document.CALENDAR_FORM.date_to.value)";
$javascript .= " fDisplayEvents(document.CALENDAR_FORM.date_to.value, '+');";
$javascript .= "});";

$javascript .= "$('#today_cal').click(function()";
$javascript .= "{";
$javascript .= "$('#$id_cal').fullCalendar('today');";
$javascript .= "});";
$javascript .= "});";
$javascript .= "document.CALENDAR_FORM.date_from.value='".date('Y-m-d',$temp_fromdate)."';";
$javascript .= "document.CALENDAR_FORM.date_to.value='".date('Y-m-d',$temp_todate)."';";

ob_clean();
header('Content-Type: text/html; charset=utf-8');
echo '<undefined>';
echo '<javascript>';
echo $javascript;
exit;
?>
