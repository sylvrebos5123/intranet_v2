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
			
			
        
	
	<?php foreach($js as $url): ?>
	<script type="text/javascript" src="<?php echo $url;?>"></script>

	<?php endforeach; ?>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.min_'.$_SESSION['langue'].'.js';?>"></script>
	
	</body>

</html>

<script>
/**********fenêtre bulle pour afficher les agents*************************************/
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
		html: 'true',
		//placement: 'bottom',
		trigger: 'hover'
	}); 
	//$('.btn-success').popover({title: "Header", content: "Blabla", trigger: "focus"}); 
});


/*********Pour afficher/cacher les cellules appartenant à un service**************************************************/

	var msg_afficher_cel="<?php echo dico('afficher_cellules',$_SESSION['langue']);?>";
	var msg_cacher_cel="<?php echo dico('cacher_cellules',$_SESSION['langue']);?>";
	
	$( 'a[id^="display_cel"]' ).each(function( index ) {
		$( this ).click(function() {
		  
			if($("div[id^='div_cel']:eq("+index+")").css('display')=="block")
			{	$("div[id^='div_cel']:eq("+index+")" ).slideUp();
				$(this).html(msg_afficher_cel);
			}
			else
			{
				$("div[id^='div_cel']:eq("+index+")" ).slideDown();
				$(this).html(msg_cacher_cel);
			}
		});
	});


</script>



