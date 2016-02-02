<div class="row">
	<div class="col-lg-12">
	
		<h1 class="page-header">
			<?php echo dico("annuaire",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("annuaire",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 text-center">
			<a href="http://intranet.cpasixelles.be/documents/annuaire_cpas.pdf" class="btn btn-primary" target="_blank">Ouvrir pdf</a>
	</div>
</div>
<?php //print_r($contrats);?>
<div class="row">
	<div class="col-sm-12">
		
		<table id="example" class="display" cellspacing="0" width="100%">
		<thead>
		<tr>
		<th></th>
		<th><?php echo dico("nom",$_SESSION['langue']); ?></th>
		<th><?php echo dico("departement",$_SESSION['langue']).' / '.dico("hors_departement",$_SESSION['langue']); ?></th>
		<th><?php echo dico("service",$_SESSION['langue']).' / '.dico("cellule",$_SESSION['langue']); ?></th>
		<th><?php echo dico("fonction",$_SESSION['langue']); ?></th>
		<th><?php echo dico("telephones",$_SESSION['langue']);?></th>
		<th><?php echo dico("email",$_SESSION['langue']);?></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		foreach($contrats as $k=>$v)
		{
		?>
		<tr>
			<td>
			<?php 
			if(empty($v->url_photo))
			{
				if($v->genre ==1)
					echo '<img src="http://intranet.cpasixelles.be/images/m_agent_256_256.png" width="100px">';
				else
					echo '<img src="http://intranet.cpasixelles.be/images/f_agent_256_256.png" width="100px">';
				
			}
			else
			{
				echo '<img src="http://intranet.cpasixelles.be/images/personnel/'.$v->url_photo.'" width="100px">';
			
			}
			//echo $v->url_photo;
			?>
			</td>
			<td><?php echo $v->nom.' '.$v->prenom;?></td>
			<td><?php 
			if(empty($v->label_dep))
			{
				echo $v->label_hors_dep;
			}
			else
			{
				echo $v->label_dep;
			}
			?>
			
			</td>
			<td>
			<?php 
			if(!empty($v->label_ser))
			{
				echo $v->label_ser;
			}
			
			if(!empty($v->label_cel))
			{
				echo ' / '.$v->label_cel;
			}
			?></td>
			
			<td>
			<?php 
			if($v->personne_confiance==1)
			{
				echo '<strong>'.dico('personne_confiance',$_SESSION['langue'])."</strong><br \>";
			}
			
			if(!empty($v->label_fonc))
			{
				echo $v->label_fonc;
			}
			
			?></td>
			<td>
			<?php 
			
			if(!empty($v->tel_1))
			{
				echo "<p>".$v->tel_1;
				
				if(!empty($v->horaire_appel_tel1))
				{
					echo ' ('.$v->horaire_appel_tel1.').</p>';
				}
			}
			
			if(!empty($v->tel_2))
			{
				echo "<p>".$v->tel_2;
				
				if(!empty($v->horaire_appel_tel2))
				{
					echo ' ('.$v->horaire_appel_tel2.').</p>';
				}
			}
			
			if(!empty($v->mobile_pro))
			{
				echo "<p>".'GSM: '.$v->mobile_pro."</p>";
			}
			?>
			</td>
			<td>
			<?php 
			if(!empty($v->email))
			{
				echo '<a href="mailto:'.$v->email.'">'.$v->email.'</a>';
			}
			?></td>
		
		</tr>
		<?php
		}
		?>
		
		</tbody>
		</table>
	</div>
</div>
				