
<div class="row">
	<div class="col-lg-12">
	
		<h1 class="page-header">
			<?php echo dico("archives",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("archives",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>