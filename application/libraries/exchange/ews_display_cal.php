<?php
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"].'\\lib\\ews.php');
include('array_lbl_cal.php');
function f_ews_agenda_display($username,$password,$workday,$start_date,$start_date,$working_days)
{
 $rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
 
 include('array_lbl_cal.php');
 $working_days = (($working_days == null) || ($working_days == '') || ($working_days < 5) || ($working_days > 7)) ? 5 : $working_days;

 $a_rdv = array();
 if ($workday == true)
  $a_rdv = GetEwsWorkingWeekListItems($username,$password,$start_date,$working_days,'');
 else
  $a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$start_date,''); 
 
 //echo '<pre>'.print_r($a_rdv, true).'</pre>';
 return $a_rdv;
}

//$code_langue = '';
//if (isset($_POST['code_langue']))
// $code_langue = trim($_POST['code_langue']);
//if (($code_langue == '') || ($code_langue == null))
// $code_langue = 'F';
$code_langue = "N";
//$code_langue = "N";

$username = 'frantz.eschenhorn@cpasxl.irisnet.be';
$password = 'claudine987*';

$start_date = '01-03-2012';
$end_date = '31-03-2012';

$Calday = date('d-m-Y');
$working_days = 5;

$workday = false;

$a_rdv = f_ews_agenda_display($username,$password,$workday,$start_date, $start_date,$working_days);
ob_clean();
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel='stylesheet' type='text/css' href='/css/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='/css/fullcalendar.print.css' media='print' />
<script language"javascript" type="text/javascript" src="/javascript/jquery-1.4.2.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/jquery-ui-1.8.9.custom.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/fullcalendar.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/gcal.js"></script>
<script language"javascript" type="text/javascript">
$(document).ready(function() {
	
$('#calendar').fullCalendar({
 header: {
  //left: 'prev,next today',
  left: '',
  center: 'title',
  right: 'month,agendaWeek,agendaDay'
 },
 columnFormat:
 {
  month: 'dd',    // Mon
  week: 'dddd<br/>dd/MM/yyyy', // Mon 9/7
  day: 'dddd<br/>dd/MM/yyyy'  // Monday 9/7
 },
 buttonText:
 {
//  prev:     '&nbsp;&#9668;&nbsp;',
//  next:     '&nbsp;&#9658;&nbsp;',
<?php
 //echo "today:'".addslashes($array_lbl['TODAY'][$code_langue])."',\n";
 echo "month:'".addslashes($array_lbl['MONTHLY'][$code_langue])."',\n";
 echo "week:'".addslashes($array_lbl['WEEKLY'][$code_langue])."',\n";
 echo "day:'".addslashes($array_lbl['DAILY'][$code_langue])."'\n";
?>
 },
 allDaySlot:false,
 //allDayText:'Toute la journée',
 defaultView:'agendaWeek',
 weekends:false,
 axisFormat:'HH:mm',
 agenda:'HH:mm{ - HH:mm}',
 timeFormat:'HH:mm{ - HH:mm}',
 firstDay:1,
 slotMinutes:30,
 defaultEventMinutes:30,
 firstHour:'7:30',
 minTime:'7:30',
 LastHour:'17:30',
 maxTime:'17:30',
 weekMode:'liquid',
 weekends:false,
 editable:false,
 //ignoreTimezone:true,
// height:350,
<?php
 $temp_string = '';
 $temparray = $array_weekday[$code_langue];
 foreach($temparray as $value)
 {
  $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
 }
 echo "dayNames:[$temp_string],\n";

 $temp_string = '';
 $temparray = $array_short_weekday[$code_langue];
 foreach($temparray as $value)
 {
  $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
 }
 echo "dayNamesShort:[$temp_string],\n";

 $temp_string = '';
 $temparray = $array_month[$code_langue];
 foreach($temparray as $value)
 {
  $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
 }
 echo "monthNames:[$temp_string],\n";

 $temp_string = '';
 $temparray = $array_short_month[$code_langue];
 foreach($temparray as $value)
 {
  $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
 }
 echo "monthAbbrevs:[$temp_string],\n";

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

 $events .= ($events != '') ? ','."\n" : '';
 $events .= '{'."\n";
 $events .= "id:'".$aevent['ID'].'||'.$aevent['CHANGEKEY']."',\n";
 $events .= "title:'$titel',\n";
// $events .= "start: new Date($y_start,$m_start,$d_start),\n";
// $events .= "end: new Date($y_end,$m_end,$d_end),\n";
 $events .= "start: '$start_exdate',\n";
 $events .= "end: '$end_exdate',\n";
// $events .= "color:'yellow',\n";
// $events .= "textColor:'black',\n";

// backgroundColor
// borderColor
 $events .= "allDay:false\n";
 //$events .= "url: 'http://google.com/'";
 $events .= '}';
}
echo 'events:['.$events."],\n";
?>
eventClick: function(calEvent, jsEvent, view)
{
 var v_ThisDate = new Date(calEvent.start);
  var vn_day = v_ThisDate.getDate();
  var vn_month = v_ThisDate.getMonth();
  var vn_year = v_ThisDate.getFullYear();
  var vn_hour = v_ThisDate.getHours()
  var vn_min = v_ThisDate.getMinutes();
  //alert(vn_day+'/'+vn_month+'/'+vn_year+' '+vn_hour+':'+vn_min);
  $("#calendar").fullCalendar( 'gotoDate', vn_year, vn_month, vn_day);

 //alert($(this).fullCalendar('getDate'));

 //alert('Event: ' + calEvent.start +'-'+ calEvent.end + '-' + calEvent.title+' '+ calEvent.id);
 //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
 //alert('View: ' + view.name);

 // change the border color just for fun
 //$(this).css('color', 'red');
}
});

$(".cal_button").mouseover(function()
{
 $(this).addClass('fc-state-hover');
 $(this).removeClass('fc-state-default');
});

$(".cal_button").mouseout(function()
{
 $(this).removeClass('fc-state-hover');
 $(this).addClass('fc-state-default');
});

$("#prev_cal").click(function()
{
 var d = $('#calendar').fullCalendar('getDate');
 //alert($('#calendar').fullCalendar('getView').name+' '+d);
 
 var vs_view = $('#calendar').fullCalendar('getView').name;
 switch (vs_view)
 {
  case 'agendaDay':
   break;
  case 'agendaWeek':
   break;
  case 'month':
   $('#calendar').fullCalendar('next');
   break;
  default:
   break;
 }
});

$("#next_cal").click(function()
{
 var d = $('#calendar').fullCalendar('getDate');
 //alert($('#calendar').fullCalendar('getView').name+' '+d);
 var vs_view = $('#calendar').fullCalendar('getView').name;
 switch (vs_view)
 {
  case 'agendaDay':
   break;
  case 'agendaWeek':
   break;
  case 'month':
   $('#calendar').fullCalendar('next');
   break;
  default:
   break;
 }
});

$("#today_cal").click(function()
{
 $('#calendar').fullCalendar('today');
});
});

//$('#calendar').fullCalendar('render');


</script>
<style type='text/css'>
	body {
		margin-top: 40px;
		text-align: center;
		font-size: 10px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 600px;
		height:500px;
		margin: 0 auto;
		font-size:90%;
		}
    #nav_fc_button {
	 position:absolute;
	 top:42px;
 	 left:330px;
	}
</style>
</head>
<body>
<div id='calendar' style="border:1px solid black;"></div>
<div id="nav_fc_button" class="fc">
<table class="fc-header" style="font-size:90%;width:100px;">
 <tr>
  <td class="fc-header-left" style="text-align:center;vertical-align:middle;">
   <span id="prev_cal" style="height:15px;width:20px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-prev fc-state-default fc-corner-left">&nbsp;&#9668;&nbsp;</span>
   <span id="next_cal" style="height:15px;width:20px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-next fc-state-default fc-corner-right">&nbsp;&#9658;&nbsp;</span>
   <span class="fc-header-space"></span>
   <span id="today_cal" style="height:15px;width:50px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right">
    <?php echo addslashes($array_lbl['TODAY'][$code_langue]); ?>
   </span>
  </td>
 </tr>
</table>
</div>
</body>
</html>
