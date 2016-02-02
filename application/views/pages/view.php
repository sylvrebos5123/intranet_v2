<?php 
$titre_article='titre_article_'.$_SESSION['langue'];
$sous_titre='sous_titre_'.$_SESSION['langue'];
$chapeau='chapeau_'.$_SESSION['langue'];
$contenu='article_'.$_SESSION['langue'];
//print_r($article);

?>
<?php
foreach($article as $row)
{

	$this->layout->set_titre($row->$titre_article);
?>
	<h1 class="page-header">
		<?php echo $row->$titre_article;?>
	</h1>
	<ol class="breadcrumb">
		<li>
			<i class="fa fa-dashboard"></i>  
			<a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>">
			<?php echo dico("accueil",$_SESSION['langue']);?>
			</a>
		</li>
		<li class="active">
			<i class="fa fa-file"></i> <?php echo $row->$titre_article;?>
		</li>
	</ol>

	<h2><?php echo $row->$sous_titre;?></h2>
	<blockquote><?php echo $row->$chapeau;?></blockquote>
	<p><?php echo $row->$contenu;?></p>
<?php
}//end foreach
?>