<?php 
//print_r($guides);?>
<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php echo dico("guides_cpas",$_SESSION['langue']); ?> 
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("guides_cpas",$_SESSION['langue']); ?> 
			</li>
		</ol>
		
		<ul>
			<?php
			foreach($guides as $k=>$v)
			{
				$sujet='sujet_'.$_SESSION['langue'];
				$lien_pdf='document_pdf_'.$_SESSION['langue'];
			?>
				<li>
					<a href="<?php echo 'http://intranet.cpasixelles.be'.$v->$lien_pdf;?>" target="_blank"><?php echo $v->$sujet;?></a>
				</li>
			<?php
			}
			?>
			
		</ul>
	</div>
</div> <!-- .row -->