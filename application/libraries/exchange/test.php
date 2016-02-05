<?php

$rootpath = addslashes($_SERVER["DOCUMENT_ROOT"]);
include($rootpath.'\\exchange\\ews.php');
include($rootpath.'\\config_ews\\config_ews.php');

//agenda officiel
$username=trim($email_array['agenda_off']['email']);
$password=trim($email_array['agenda_off']['email_psw']);
$start_date='01-02-2016';
$end_date='01-04-2016';
$a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
//print_r($a_rdv);

foreach($a_rdv as $k=>$v)
{
	echo $v['START_DATE'];
	echo $v['END_DATE'];
	echo $v['SUJET'];
	echo $v['OU'];
	echo $v['START_HEURE'];
	echo $v['END_HEURE'];
?>
<br>
<?php
}
//mon agenda
$username='sylvie.vrebos@cpasxl.irisnet.be';
$password='ixelles1';
$start_date='01-02-2016';
$end_date='01-04-2016';
$a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
//print_r($a_rdv);

echo 'mon agenda<br>';
foreach($a_rdv as $k=>$v)
{
	echo $v['START_DATE'];
	echo $v['END_DATE'];
	echo $v['SUJET'];
	echo $v['OU'];
	echo $v['START_HEURE'];
	echo $v['END_HEURE'];
?>
<br>
<?php
}