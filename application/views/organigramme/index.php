
<!-- Titre + fil d'ariane -->
<div class="row">
	<div class="col-lg-12">
	
		<h1 class="page-header">
			<?php echo dico("organigramme_cpas",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-sitemap"></i> <?php echo dico("organigramme_cpas",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>


<!-- Organigramme -->
<div class="row">
	
	<div class="col-lg-2">
		<div class="top_hierarchie"><?php echo dico('cpas',$_SESSION['langue']);?></div>
		<p class="text-center"><img src="<?php echo img_url('vertical-line.png');?>"></p>
	</div>
	<div class="col-lg-10"></div>
</div>

<div class="row">
	
	<div class="col-lg-2">
		<!--<button class="btn btn-success btn-md">Click me</button>-->
		<div class="top_hierarchie" data-toggle="popover" data-placement="bottom" data-content="BACK Alain"><?php echo dico('president',$_SESSION['langue']);?></div>
	</div>
	<?php
	
	//Hors départements
	foreach($hors_dep as $k=>$v)
	{
		$list_agents='';
		// Liste agents
		foreach($agents_hors_dep as $k_agents=>$v_agents)
		{
			
			//Agents
			if($v_agents->id_hors_dep==$v->id_hors_dep)
			{
				$list_agents.=$v_agents->nom.' '.$v_agents->prenom."<br \>";
			}
			
		}
		
		if(empty($list_agents))
		{
			$list_agents=dico('aucun_agent_connu',$_SESSION['langue']);
		}
		
	?>
	<div class="col-lg-2 ">
		<div class="hors_dep" data-toggle="popover" data-placement="bottom" data-content="<?php echo $list_agents;?>">
			<?php echo $v->{'label_'.$_SESSION['langue']};?>
		</div>
	</div>
	<?php

	}

	?>
</div>

<br></br>

<div class="row">
<?php

//Départements
foreach($dep as $k=>$v)
{	
	$list_agents='';
	$resp='';
	// Liste agents
	foreach($agents_dep as $k_agents=>$v_agents)
	{
		
		//Responsable
		if(($v_agents->id_dep==$v->id_dep)&&($v_agents->flag_resp_dep==1))
		{
			$resp=$v_agents->nom.' '.$v_agents->prenom;
		}
		//Agents
		if(($v_agents->id_dep==$v->id_dep)&&($v_agents->flag_resp_dep==0))
		{
			$list_agents.=$v_agents->nom.' '.$v_agents->prenom."<br \>";
		}
	}
	if(empty($resp))
	{
		$resp=dico('aucun_resp_connu',$_SESSION['langue']);
	}
	if(empty($list_agents))
	{
		$list_agents=dico('aucun_adjoint_connu',$_SESSION['langue']);
	}
?>
	<div class="col-lg-2">
		<div class="dep" data-toggle="popover" data-placement="bottom" title="<?php echo $resp;?>" data-content="<?php echo $list_agents;?>">
			<?php echo $v->{'label_'.$_SESSION['langue']};?>
		</div>
		<p class="text-center"><img src="<?php echo img_url('vertical-line.png');?>"></p>
	
	
<?php	
	foreach($ser as $k2=>$v2)
	{
		// Si services
		if($v2->id_dep == $v->id_dep)
		{

			$list_agents='';
			$resp='';
			// Liste agents
			foreach($agents_ser as $k_agents=>$v_agents)
			{
				
				//Responsable
				if(($v_agents->id_ser==$v2->id_ser)&&($v_agents->flag_resp_ser==1))
				{
					$resp=$v_agents->nom.' '.$v_agents->prenom;
				}
				//Agents
				if(($v_agents->id_ser==$v2->id_ser)&&($v_agents->flag_resp_ser==0))
				{
					$list_agents.=$v_agents->nom.' '.$v_agents->prenom."<br \>";
				}
			}
			if(empty($resp))
			{
				$resp=dico('aucun_resp_connu',$_SESSION['langue']);
			}
			if(empty($list_agents))
			{
				$list_agents=dico('aucun_adjoint_agent_connu',$_SESSION['langue']);
			}
	?>
			<div class="ser" data-toggle="popover" data-placement="right" title="<?php echo $resp;?>" data-content="<?php echo $list_agents;?>">
				<?php echo $v2->{'label_'.$_SESSION['langue']};?>
			</div>
			<?php
			//calcul nb de cellules par services
			
			$nb_cel=$this->db->select('*')
							->from('cpas_cellules')
							->where(array('id_ser'=>$v2->id_ser))
							->count_all_results();
			
			//echo $nb_cel;
			if($nb_cel>0) //s'il existe une ou plusieurs cellules
			{
			?>
				<p class="text-center"><a id="display_cel"><?php echo dico('afficher_cellules',$_SESSION['langue']);?></a></p>
				<div id="div_cel">
				<?php
				foreach($cel as $k3=>$v3)
				{
					// Si cellules
					if($v3->id_ser == $v2->id_ser)
					{
						$list_agents='';
						$resp='';
						// Liste agents
						foreach($agents_cel as $k_agents=>$v_agents)
						{
							
							//Responsable
							if(($v_agents->id_cel==$v3->id_cel)&&($v_agents->flag_resp_ser==1))
							{
								$resp=$v_agents->nom.' '.$v_agents->prenom;
							}
							//Agents
							if(($v_agents->id_cel==$v3->id_cel)&&($v_agents->flag_resp_ser==0))
							{
								$list_agents.=$v_agents->nom.' '.$v_agents->prenom."<br \>";
							}
						}
						if(empty($resp))
						{
							$resp=dico('aucun_resp_connu',$_SESSION['langue']);
						}
						if(empty($list_agents))
						{
							$list_agents=dico('aucun_agent_connu',$_SESSION['langue']);
						}
						?>
						<img src="<?php echo img_url('vertical-line.png');?>">
							<div class="cel" data-toggle="popover" data-placement="right" title="<?php echo $resp;?>" data-content="<?php echo $list_agents;?>"><?php echo $v3->{'label_'.$_SESSION['langue']}?></div>
					<?php
					}
					
					
				}//fin foreach cel
				?>
				</div>
		
		<?php
			}// fin if($nb_cel>0)
		} // fin if($v2->id_dep == $v->id_dep)		
		
	}//fin foreach ser
?>
	
	</div> <!-- fin col -->
<?php
} //fin foreach dep
?>
	
</div> <!-- fin row -->

