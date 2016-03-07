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

	<body id="home" data-spy="scroll" data-target=".navbar-fixed-top">
	<div id="wrapper">
		
	  
        <!-- Navigation -->
        
            <?php include('menu.php');?>
			
			<?php require_once('sidebar2.php');?>
        

        <div id="page-wrapper">

		<div class="container-fluid">
			<?php echo $output; ?>
		
		
		</div>
            <!-- /.container-fluid -->
			
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<?php foreach($js as $url): ?>
	<script type="text/javascript" src="<?php echo $url;?>"></script>

	<?php endforeach; ?>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.min_'.$_SESSION['langue'].'.js';?>"></script>
	
	</body>

</html>

<script>
	$(document).ready(function() {
			$('#example').DataTable();
		} );
// For demo to fit into DataTables site builder...
	//$('div.dataTables_length').html('Montrer');
	$('#example')
		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');

		
//effet hover boutons sidebar
var url=document.location.href;
var page=url.substring(url.lastIndexOf('/pages'));

var new_page=page.substring(0,page.lastIndexOf('?'));
//console.log(new_page);

switch(new_page)
{
	case '/pages/index': 
		$(".side-nav>li:eq(1)").addClass('active');
		break;
	case '/pages/send_order_cartridge':
		$(".side-nav>li:eq(3)").addClass('active');
		break;
	case '/pages/guides': 
		$(".side-nav>li:eq(4)").addClass('active');
		break;
	case '/pages/applications': 
		$(".side-nav>li:eq(5)").addClass('active');
		break;
	case '/pages/archives': 
		$(".side-nav>li:eq(6)").addClass('active');
		break;
	default:
		$(".side-nav>li:eq(1)").addClass('active');
		break;
}

/********Permet d'ouvrir l'explorateur Windows****************************/
function fOpenExplorer(ps_path)
{
 if(window.ActiveXObject)// IE
 {
	var obj = new ActiveXObject("WScript.Shell" );
	obj.run('explorer.exe '+ps_path);
 }
 else
 {
 window.open(ps_path);
 }
 
 return true;
}

</script>

