<?php
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include('array_lbl_cal.php');
$code_langue = 'F';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel='stylesheet' type='text/css' href='/css/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='/css/fullcalendar.print.css' media='print' />
<script language"javascript" type="text/javascript" src="/javascript/jquery-1.4.2.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/jquery-ui-1.8.9.custom.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/ajax.jquery_script.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/fullcalendar.min.js"></script>
<script language"javascript" type="text/javascript" src="/javascript/gcal.js"></script>
<script language"javascript" type="text/javascript">
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
 top:45px;
 left:330px;
 z-index:10;
}

#ajax-panel {
 position:absolute;
 top:68px;
 left:0px;
 width:100%;
 text-align:center;
 z-index:10;
}

</style>
<script language="javascript">
function fDisplayEvents(ps_div,ps_obj,ps_date,ps_date_to,ps_direction)
{
 $.ajax
 ({
  url: "./ews_fill_events.php",
  type:'post',
  data:{id_cal:ps_div,id_obj:ps_obj,username:'frantz.eschenhorn@cpasxl.irisnet.be',password:'claudine159*',param_date:ps_date,param_date_to:ps_date_to,param_direction:ps_direction,workday:0,working_days:5,code_langue:'N'},
  beforeSend:function()
  {
   // this is where we append a loading image
   $('#ajax-panel').html('<img src="/images/ajax_loader.gif" />');
  },
  success: function(data)
  {
   var vs_javascript = '';
   var as_contenu = data.split('<javascript>');
   var vs_html = as_contenu[0];

   if ((vs_html == '') || (vs_html == null))
    vs_html = '';

   if ((vs_html == '<undefined>') || (vs_html == 'undefined'))
    ps_div = '';

   if (typeof as_contenu[1] != 'undefined')
    vs_javascript = as_contenu[1];

   if ((as_contenu[1] == null) || (vs_javascript == null) || (vs_javascript == '') || (vs_javascript == '<undefined>') || (vs_javascript == 'undefined'))
    vs_javascript = '';

   if (vs_javascript != '')
    eval(vs_javascript);

   $('#ajax-panel').empty();
  },
  error:function()
  {
   $('#ajax-panel').empty();
  }
 });
}

function fFillEvent(po_cal,ps_id_cal,ps_id, ps_key, ps_title, ps_from, ps_to)
{
 //$events .= "color:'yellow',";
 //$events .= "textColor:'black',";
 //backgroundColor
 //borderColor
 //$events .= "url: 'http://google.com/'";
 
 if (typeof as_event[ps_id] == 'undefined')
 {
  po_cal.fullCalendar('renderEvent',
  {
   id:ps_id,
   title:ps_title,
   start:ps_from,
   end:ps_to,
   allDay:false
  },true);
 }
 else
 {
  //var reg_1=new RegExp("T", "g");
  //var reg_2=new RegExp("Z", "g");
  //alert(ps_from.replace(reg_1,' ').replace(reg_2,''));
  //alert(ps_to.replace(reg_1,' ').replace(reg_2,''));
  
  var event_cal = po_cal.fullCalendar('clientEvents',function(event) { return (ps_id===event.id);})[0];
  
  event_cal.title = ps_title;
  event_cal.start = ps_from;
  event_cal.end = ps_to;
  $('#'+ps_id_cal).fullCalendar('updateEvent', event_cal);
 }
 as_event[ps_id] = ps_key;
}

var cal;
var as_event = new Array();

$(document).ready(function()
{
 cal = $("#calendar").fullCalendar(
 {
  header:
  {
   //left:'prev,next today',
   left: '',
   center: 'title',
   right: 'month,agendaWeek,agendaDay'
  },
  columnFormat:
  {
   month: 'dddd',
   week: 'dddd<br/>dd/MM/yyyy',
   day: 'dddd<br/>dd/MM/yyyy'
  },
  buttonText:
  {
   //  prev:     '&nbsp;&#9668;&nbsp;',
   //  next:     '&nbsp;&#9658;&nbsp;',
   // today:'".addslashes($array_lbl['TODAY'][$code_langue])."',
   month:<?php echo "'".addslashes($array_lbl['MONTHLY'][$code_langue])."'"; ?>,
   week:<?php echo "'".addslashes($array_lbl['WEEKLY'][$code_langue])."'"; ?>,
   day:<?php echo "'".addslashes($array_lbl['DAILY'][$code_langue])."'"; ?>
  },
  allDaySlot:false,
  //allDayText:'Toute la journée',
  defaultView:'agendaWeek',
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
$html_name = '';
$temp_string = '';
$temparray = $array_weekday[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$html_name = "  dayNames:[$temp_string],\n";

$temp_string = '';
$temparray = $array_short_weekday[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$html_name .= "  dayNamesShort:[$temp_string],\n";

$temp_string = '';
$temparray = $array_month[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$html_name .= "  monthNames:[$temp_string],\n";

$temp_string = '';
$temparray = $array_short_month[$code_langue];
foreach($temparray as $value)
{
 $temp_string .= ($temp_string== '') ? "'".addslashes($value)."'" : ",'".addslashes($value)."'";
}
$html_name .= "  monthAbbrevs:[$temp_string],\n";
echo $html_name;
?>
  events:[],
  eventClick: function(calEvent, jsEvent, view)
  {
   alert(calEvent.id);
   var v_ThisDate = new Date(calEvent.start);
   var vn_day = v_ThisDate.getDate();
   var vn_month = v_ThisDate.getMonth();
   var vn_year = v_ThisDate.getFullYear();
   var vn_hour = v_ThisDate.getHours();
   var vn_min = v_ThisDate.getMinutes();
   $('#calendar').fullCalendar( 'gotoDate', vn_year, vn_month, vn_day);
   alert(document.CALENDAR_FORM.date_from.value);
   alert(document.CALENDAR_FORM.date_to.value);
   //alert('Event: ' + calEvent.start +'-'+ calEvent.end + '-' + calEvent.title+' '+ calEvent.id);
   //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
   //alert('View: ' + view.name);
   // change the border color just for fun
   $(this).css('borderColor', 'red');
  }
 });
 fDisplayEvents('calendar','cal','','', 's');
 
 //fAjax('coucou.php','calendar',{id_cal:'coucou',id_obj:'coucou',username:'frantz.eschenhorn@cpasxl.irisnet.be'});
 
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
  var d = $("#calendar").fullCalendar('getDate');
  $("#calendar").fullCalendar('prev');
  var vs_view = $("#calendar").fullCalendar('getView').name;

  var v_ThisDate = new Date($('#calendar').fullCalendar('getView').visStart);
  var vn_day_start = v_ThisDate.getDate();
  var vn_month_start = v_ThisDate.getMonth()+1;
  var vn_year_start = v_ThisDate.getFullYear();
  var vn_hour_start = v_ThisDate.getHours();
  var vn_min_start = v_ThisDate.getMinutes();
  var vs_month_start = (vn_month_start < 10) ? '0'+vn_month_start : vn_month_start;
  var vs_day_start = (vn_day_start < 10) ? '0'+vn_day_start : vn_day_start;
  var vs_date_start = vn_year_start+'-'+vs_month_start+'-'+vs_day_start;

  var v_ThisDate = new Date($("#calendar").fullCalendar('getView').visEnd);
  var vn_day_end = v_ThisDate.getDate();
  var vn_month_end = v_ThisDate.getMonth()+1;
  var vn_year_end = v_ThisDate.getFullYear();
  var vn_hour_end = v_ThisDate.getHours();
  var vn_min_end = v_ThisDate.getMinutes();
  var vs_month_end = (vn_month_end < 10) ? '0'+vn_month_end : vn_month_end;
  var vs_day_end = (vn_day_end < 10) ? '0'+vn_day_end : vn_day_end;
  var vs_date_end = vn_year_end+'-'+vs_month_end+'-'+vs_day_end;

  if (vs_date_start < document.CALENDAR_FORM.date_from.value)
   fDisplayEvents('calendar','cal',document.CALENDAR_FORM.date_from.value,'','-');
  else
   fDisplayEvents('calendar','cal',vs_date_start, vs_date_end,'d');
 });

 $("#next_cal").click(function()
 {
  var d = $("#calendar").fullCalendar('getDate');

  var vs_view = $("#calendar").fullCalendar('getView').name;
  $("#calendar").fullCalendar('next');

  var v_ThisDate = new Date($("#calendar").fullCalendar('getView').visStart);
  var vn_day_start = v_ThisDate.getDate();
  var vn_month_start = v_ThisDate.getMonth()+1;
  var vn_year_start = v_ThisDate.getFullYear();
  var vn_hour_start = v_ThisDate.getHours();
  var vn_min_start = v_ThisDate.getMinutes();
  var vs_month_start = (vn_month_start < 10) ? '0'+vn_month_start : vn_month_start;
  var vs_day_start = (vn_day_start < 10) ? '0'+vn_day_start : vn_day_start;
  var vs_date_start = vn_year_start+'-'+vs_month_start+'-'+vs_day_start;

  var v_ThisDate = new Date($('#calendar').fullCalendar('getView').visEnd);
  var vn_day_end = v_ThisDate.getDate();
  var vn_month_end = v_ThisDate.getMonth()+1;
  var vn_year_end = v_ThisDate.getFullYear();
  var vn_hour_end = v_ThisDate.getHours();
  var vn_min_end = v_ThisDate.getMinutes();
  var vs_month_end = (vn_month_end < 10) ? '0'+vn_month_end : vn_month_end;
  var vs_day_end = (vn_day_end < 10) ? '0'+vn_day_end : vn_day_end;
  var vs_date_end = vn_year_end+'-'+vs_month_end+'-'+vs_day_end;
  if (vs_date_end > document.CALENDAR_FORM.date_to.value)
   fDisplayEvents('calendar','cal',document.CALENDAR_FORM.date_to.value,'','+');
  else
   fDisplayEvents('calendar','cal',vs_date_start, vs_date_end,'d');
 });

 $("#today_cal").click(function()
 {
  var d = $("#calendar").fullCalendar('getDate');

  var vs_view = $("#calendar").fullCalendar('getView').name;
  $("#calendar").fullCalendar('today');

  var v_ThisDate = new Date($("#calendar").fullCalendar('getView').visStart);
  var vn_day_start = v_ThisDate.getDate();
  var vn_month_start = v_ThisDate.getMonth()+1;
  var vn_year_start = v_ThisDate.getFullYear();
  var vn_hour_start = v_ThisDate.getHours();
  var vn_min_start = v_ThisDate.getMinutes();
  var vs_month_start = (vn_month_start < 10) ? '0'+vn_month_start : vn_month_start;
  var vs_day_start = (vn_day_start < 10) ? '0'+vn_day_start : vn_day_start;
  var vs_date_start = vn_year_start+'-'+vs_month_start+'-'+vs_day_start;

  var v_ThisDate = new Date($('#calendar').fullCalendar('getView').visEnd);
  var vn_day_end = v_ThisDate.getDate();
  var vn_month_end = v_ThisDate.getMonth()+1;
  var vn_year_end = v_ThisDate.getFullYear();
  var vn_hour_end = v_ThisDate.getHours();
  var vn_min_end = v_ThisDate.getMinutes();
  var vs_month_end = (vn_month_end < 10) ? '0'+vn_month_end : vn_month_end;
  var vs_day_end = (vn_day_end < 10) ? '0'+vn_day_end : vn_day_end;
  var vs_date_end = vn_year_end+'-'+vs_month_end+'-'+vs_day_end;
  fDisplayEvents('calendar','cal',vs_date_start, vs_date_end,'d');
 });
});
</script>
</head>
<body>
<div id="calendar"></div>
<div id="nav_fc_button" class="fc">
 <table class="fc-header" style="font-size:90%;width:100px;">
  <tr>
   <td class="fc-header-left" style="text-align:center;vertical-align:middle;">
    <span id="prev_cal" style="height:15px;width:20px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-prev fc-state-default fc-corner-left">&nbsp;&#9668;&nbsp;</span>
    <span id="next_cal" style="height:15px;width:20px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-next fc-state-default fc-corner-right">&nbsp;&#9658;&nbsp;</span>
    <span class="fc-header-space"></span>
    <span id="today_cal" style="height:15px;width:50px;border:solid 1px #c4c4c4;" class="cal_button fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right">
     <?php echo $array_lbl['TODAY'][$code_langue]; ?>
    </span>
   </td>
  </tr>
 </table>
</div>
<div id="ajax-panel"></div>
<form name="CALENDAR_FORM" style="display:none;visibility:invisible;height:0px;width:0px;">
 <input type="hidden" name="date_from" value="" />
 <input type="hidden" name="date_to" value="" />
</form>
</body>
</html>