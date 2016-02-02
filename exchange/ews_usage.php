<?php
$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include('ews.php');

$username = 'frantz.eschenhorn@cpasxl.irisnet.be';
$password = 'claudine159*';

//$Calday = '09-03-2012';
//echo $Calday.'<br />';
//$working_days = 5;

//$a_rdv = GetEwsWorkingWeekListItems($username,$password,$Calday,$working_days,'D');
//echo '<pre>'.print_r($a_rdv, true).'</pre>';

//$a_rdv = GetEwsWorkingWeekListItems($username,$password,$Calday,$working_days,'');
//echo '<pre>'.print_r($a_rdv, true).'</pre>';

//$a_rdv = GetEwsCalFromToListItems($username,$password,'01-02-2012','30-04-2012','D');
//echo '<pre>'.print_r($a_rdv, true).'</pre>';

$item_id = "AAAjAGZyYW50ei5lc2NoZW5ob3JuQGNwYXN4bC5pcmlzbmV0LmJlAEYAAAAAAA56uIaKVeZHgG//IteiaVMHAOn6dZ6w6hZHkKPCPEYQEFQAAADIFW0AADromyzgoF1JnxdJiPKE0bcAFcrU9G0AAA==";
//$ChangeKey = "DwAAABYAAADp+nWesOoWR5CjwjxGEBBUAAAbb8Rc";
$a_rdv = GetEwsCalendarItem($username,$password,$item_id);
echo '<pre>'.print_r($a_rdv, true).'</pre>';
/*

$array_rdv = array();
$array_rdv['SUJET'] = 'Test rendez-vous';
$array_rdv['OU'] = 'Bureau test';
$array_rdv['START_DATE'] = '09-03-2012';
$array_rdv['START_HEURE'] = '10:00:00';
$array_rdv['END_DATE'] = '09-03-2012';
$array_rdv['END_HEURE'] = '10:30:00';
// false - true
$array_rdv['ALLDAY'] = false;
 
// Busy - Free
$array_rdv['BUSYSTATUS'] = 'Free';

$array_rdv['CATEGORY'] = array('Catégorie Rouge','Urgent');
 
// Text - HTML
$array_rdv['BODYTYPE'] = 'HTML';
$array_rdv['BODY'] = 'Coucou';

$array_rdv['REQ_INVITE'] = array();
$Attendess = array();
$Attendess[] = array('NAME'=>'Eschenhorn Frantz','EMAIL'=>'feschenhorn@gmail.com');
$Attendess[] = array('NAME'=>'F.Eschenhorn','EMAIL'=>'frantz.eschenhorn@gmail.com');
$array_rdv['REQ_INVITE'] = $Attendess;

$array_rdv['OPT_INVITE'] = array();
$Attendess = array();
$Attendess[] = array('NAME'=>'Eschenhorn Fr.','EMAIL'=>'feschenhorn@skynet.be');
$Attendess[] = array('NAME'=>'Fr.Eschenhorn','EMAIL'=>'frantz.eschenhorn@skynet.be');
$array_rdv['OPT_INVITE'] = $Attendess;

//SEND_TO_NONE
//SEND_ONLY_TO_ALL
//SEND_TO_ALL_AND_SAVE_COPY

$array_rdv['SENDINVIT'] = 'SEND_TO_ALL_AND_SAVE_COPY';

$username = 'frantz.eschenhorn@cpasxl.irisnet.be';
$password = 'claudine159*';

$a_rdv = CreateEwsCalendarItem($username,$password,$array_rdv);
echo '<pre>'.print_r($a_rdv, true).'</pre>';
*/
exit;
?>