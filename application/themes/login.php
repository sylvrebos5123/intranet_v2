<?php
require_once APPPATH. '/tools/generate_dico.php';

?>

<!DOCTYPE HTML>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <meta name="author" content="Sylvie Vrebos" >
	<title>Intranet CPAS-OCMW</title>
	<!-- Bootstrap Core CSS -->
    <?php foreach($css as $url): ?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
		<?php endforeach; ?>
   
    
</head>
 <body>
 

  
		<div class="container">
		
			<?php echo $output;?>
				

		</div>
		<!-- /.container-->
			
</body>

</html>


 
