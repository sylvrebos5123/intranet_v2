<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php echo dico('mes_applications',$_SESSION['langue']);?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-laptop"></i> <?php echo dico('mes_applications',$_SESSION['langue']);?>
			</li>
		</ol>
		
		<ul>
			<?php 
			foreach($applis as $k=>$v)
			{
				$sous_menu='sous_menu_'.$_SESSION['langue'];
				
				$lien='';
				if(empty($v->lien))
				{
					$lien='#';
				}
				else
				{
					$lien=$v->lien.'?session_username='.$_SESSION['User']->login_nt.'&session_langue='.$_SESSION['User']->langue;
				}
			?>
				<li>
					<a href="<?php echo ROOT.'/'.$lien;?>" target="_blank"><?php echo $v->$sous_menu;?></a>
				</li>
			<?php
			}
			?>
			
		</ul>
	</div>
</div> <!-- .row -->
