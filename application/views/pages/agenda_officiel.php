
<div class="row">
	<div class="col-lg-12">
	
		<h1 class="page-header">
			<?php echo dico("agenda_officiel",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("agenda_officiel",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php

		/*$rootpath = APPPATH.'\\libraries';
		include($rootpath.'\\exchange\\ews.php');
		include($rootpath.'\\config_ews\\config_ews.php');

		//agenda officiel
		$username=trim($email_array['agenda_off']['email']);
		$password=trim($email_array['agenda_off']['email_psw']);
		$start_date='01-02-2016';
		$end_date='01-04-2016';
		$a_rdv = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); */
		//print_r($a_rdv);

		/*foreach($a_rdv as $k=>$v)
		{
			echo $v['START_DATE'];
			echo $v['END_DATE'];
			echo $v['SUJET'];
			echo $v['OU'];
			echo $v['START_HEURE'];
			echo $v['END_HEURE'];*/
		?>
		<br>
		<?php
		//}
		//mon agenda
		/*$username='sylvie.vrebos@cpasxl.irisnet.be';
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
			echo $v['END_HEURE'];*/
		?>
		<br>
		<?php
		//}
		?>
	</div>
</div>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url().'assets/fullcalendar-2.6.0/fullcalendar.css';?>" />

<link href="<?php echo base_url().'assets/fullcalendar-2.6.0/fullcalendar.print.css';?>" rel='stylesheet' media='print' />
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
<div id='calendar'></div>
<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>lib/moment.min.js'></script>
<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>lib/jquery.min.js'></script>
<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2016-01-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2016-01-01'
				},
				{
					title: 'Long Event',
					start: '2016-01-07',
					end: '2016-01-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-01-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-01-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2016-01-11',
					end: '2016-01-13'
				},
				{
					title: 'Meeting',
					start: '2016-01-12T10:30:00',
					end: '2016-01-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2016-01-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2016-01-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2016-01-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2016-01-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2016-01-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-01-28'
				}
			]
		});
		
	});

</script>

