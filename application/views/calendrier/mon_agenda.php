
<div class="row">
	<div class="col-lg-12">
	
		<h1 class="page-header">
			<?php echo dico("mon_agenda",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("mon_agenda",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>


<div id='calendar'></div>
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?php echo date('Y-m-d');?>',
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
			editable: false,
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
			?>
				{
					title: '<?php echo $v['SUJET'].$ou;?>',
					start: '<?php echo $end_date[2].'-'.$end_date[1].'-'.$end_date[0].'T'.$v['START_HEURE'];?>',
					end: '<?php echo $v['END_DATE'].'T'.$v['END_HEURE'];?>'
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
		
	});

</script>

