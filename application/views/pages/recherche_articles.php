<?php 
$titre_article='titre_article_'.$_SESSION['langue'];
$sous_titre='sous_titre_'.$_SESSION['langue'];
$chapeau='chapeau_'.$_SESSION['langue'];
$contenu='article_'.$_SESSION['langue'];

$title_for_layout = 'Recherche articles';


if(empty($_POST['search']))
{
?>
	<h1 class="page-header">
		<?php echo dico('msg_recherche_vide',$_SESSION['langue']);?>
		
	</h1>
	<ol class="breadcrumb">
		<li>
			<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico('accueil',$_SESSION['langue']);?></a>
		</li>
		<li class="active">
			<i class="fa fa-file"></i> <?php echo dico('recherche_articles',$_SESSION['langue']);?>
		</li>
	</ol>
<?php
}
else
{
?>
<div class="row">
  <div class="col-lg-12">
	<h1 class="page-header">
		<?php echo dico('resultat_recherche_mot',$_SESSION['langue']);?> : "<?php echo $_POST['search'];?>"
	</h1>
	<ol class="breadcrumb">
		<li>
			<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico('accueil',$_SESSION['langue']);?></a>
		</li>
		<li class="active">
			<i class="fa fa-file"></i> <?php echo dico('recherche_articles',$_SESSION['langue']);?>
		</li>
	</ol>

	<?php
	if(!empty($resultats))
	{
	?>
	
	<?php
		foreach($resultats as $k=>$v)
		{
		?>
			<p>
				<a href="<?php echo site_url('pages/view/'.$v->id_article.'?langue='.$_SESSION['langue']);?>">
					<?php echo $v->$titre_article.' - '.$v->$sous_titre;?>
				</a>
			</p>
			<hr>
		<?php
		}
		?>
	
	<?php
	}
	else
	{
		echo dico('msg_recherche_vide',$_SESSION['langue']);
	}
	?>
  </div>
</div>
<?php
}
?>