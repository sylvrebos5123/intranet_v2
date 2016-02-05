<?php
require_once APPPATH. '/tools/generate_dico.php';

//Inside the file libraries/layout.php
/*if(isset($_GET['langue']))
{
	$_SESSION['langue']=$_GET['langue'];
}
else
{
	$_SESSION['langue']="F";
}*/

if(!isset($_SESSION['User']))
{
	redirect(site_url("user/login"));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" > 
	<head>
		<title><?php echo $titre; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->config->item('charset'); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css';?>" />

		<?php foreach($css as $url): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
		<?php endforeach; ?>
		
		<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>lib/moment.min.js'></script>
		<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>lib/jquery.min.js'></script>
		<script src='<?php echo base_url().'assets/fullcalendar-2.6.0/';?>fullcalendar.min.js'></script>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url().'assets/fullcalendar-2.6.0/fullcalendar.css';?>" />
		<link href="<?php echo base_url().'assets/fullcalendar-2.6.0/fullcalendar.print.css';?>" rel='stylesheet' media='print' />
	
		<style>

			body {
				margin: 5px;
				background-color:white;
			}

			#calendar {
				max-width: 900px;
				margin: 0 auto;
			}
			
			a.lang
			{
			text-decoration:none;
			color:black;
			font-weight:bold;
			}

		</style>
	</head>

	<body>

		<div class="container-fluid">
		<p class="text-right">
			<a class="lang" href="?langue=F" title="Français">
				<img src="<?php echo base_url().'assets/img/fr.gif';?>">&nbsp; F &nbsp;
			</a>
		
			<a class="lang" href="?langue=N" title="Nederlands">
				<img src="<?php echo base_url().'assets/img/nl.gif';?>">&nbsp; N &nbsp;
			</a>
		</p>
		</div>

		<div class="container-fluid">
			<?php echo $output; ?>
		
		
		</div>
            <!-- /.container-fluid -->
			
	</body>

</html>






