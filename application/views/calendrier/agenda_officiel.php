<?php
// switch language calendar
	$lang='';
	
	switch($_GET['langue'])
	{
		case 'F':$lang='fr';
				break;
		case 'N':$lang='nl';
				break;
		default:$lang='fr';
				break;
	
	}
?>
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

	

<div id='calendar'></div>

<script>

	$(document).ready(function() {
		var currentTimezone = false;
		var currentLangCode='<?php echo $lang;?>';
		// when the timezone selector changes, rerender the calendar
		$('#timezone-selector').on('change', function() {
			currentTimezone = this.value || false;
			$('#calendar').fullCalendar('destroy');
			renderCalendar();
		});

		function renderCalendar() {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				defaultDate: '<?php echo date('Y-m-d');?>',
				businessHours: true,
				defaultView:'agendaWeek',
				timezone: currentTimezone,
				lang: currentLangCode,
				editable: false,
				selectable: false,
				eventLimit: true, // allow "more" link when too many events
				timeFormat: 'H:mm', // uppercase H for 24-hour clock
				events: [
					<?php	
				foreach($a_rdv as $k=>$v) //result data
				{
					$start_date=explode('/',$v['START_DATE']);
					$end_date=explode('/',$v['END_DATE']);
					if($v['OU']=='')
					{
						$ou='';
					}
					else
					{
						$ou=' - '.$v['OU'];
					}
					
					//start_heure
					if(empty($v['START_HEURE']))
					{
						$start_heure='';
					}
					else
					{
						$start_heure='T'.$v['START_HEURE'];
					
					}
					//end_heure
					if(empty($v['END_HEURE']))
					{
						$end_heure='';
					}
					else
					{
						$end_heure='T'.$v['END_HEURE'];
					
					}
			?>
					{
						title: '<?php echo $v['SUJET'].$ou;?>',
						start: '<?php echo $start_date[2].'-'.$start_date[1].'-'.$start_date[0].$start_heure;?>',
						end: '<?php echo $end_date[2].'-'.$end_date[1].'-'.$end_date[0].$end_heure;?>',
						color: '#039691'
					},
				
			<?php
				}
			?>
					{
						title: 'All Day Event',
						start: '0000-00-00'
					}


				],
				loading: function(bool) {
					$('#loading').toggle(bool);
				},
				eventRender: function(event, el) {
					// render the timezone offset below the event title
					if (event.start.hasZone()) {
						el.find('.fc-title').after(
							$('<div class="tzo"/>').text(event.start.format('Z'))
						);
					}
				},
				dayClick: function(date) {
					console.log('dayClick', date.format());
				},
				select: function(startDate, endDate) {
					console.log('select', startDate.format(), endDate.format());
				}
			});
		}

		renderCalendar();
	});


	/*$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?php echo date('Y-m-d');?>',
			defaultView: 'basicWeek',
			timezone: 'UTC',
			ignoreTimezone: false,

			/*buttonText :
			{
			today:    '<?php echo dico('today',$_SESSION['langue']);?>',
			month:    '<?php echo dico('monthly',$_SESSION['langue']);?>',
			week:     '<?php echo dico('week',$_SESSION['langue']);?>',
			day:      '<?php echo dico('day',$_SESSION['langue']);?>'	
			},
			monthNames:
			['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
			'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			dayNamesShort:
			['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
			*/
			/*editable: false,
			eventLimit: true, // allow "more" link when too many events
			
			events: [
			
			<?php	
			foreach($a_rdv as $k=>$v) //result data
			{
				$start_date=explode('/',$v['START_DATE']);
				$end_date=explode('/',$v['END_DATE']);
				if($v['OU']=='')
				{
					$ou='';
				}
				else
				{
					$ou=' - '.$v['OU'];
				}
				
				//start_heure
				if(empty($v['START_HEURE']))
				{
					$start_heure='';
				}
				else
				{
					$start_heure='T'.$v['START_HEURE'];
				
				}
				//end_heure
				if(empty($v['END_HEURE']))
				{
					$end_heure='';
				}
				else
				{
					$end_heure='T'.$v['END_HEURE'];
				
				}
			?>
				{
					title: '<?php echo $v['SUJET'].$ou;?>',
					start: '<?php echo $start_date[2].'-'.$start_date[1].'-'.$start_date[0].$start_heure;?>',
					end: '<?php echo $end_date[2].'-'.$end_date[1].'-'.$end_date[0].$end_heure;?>'
				},
				
			<?php
			}
			?>
				{
					title: 'All Day Event',
					start: '0000-00-00'
				}
			
			],
			 timeFormat: 'H:mm' // uppercase H for 24-hour clock
			
		});
		
	});*/

</script>

