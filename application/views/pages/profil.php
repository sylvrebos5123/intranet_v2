<div class="row">
	<div class="col-lg-12">
	<?php
	if(!empty($_SESSION['flash_message']))
	{
	?>
	
	<p class="alert alert-success"><?php echo $_SESSION['flash_message']; ?></p>
	<?php
	}
	?>
		<h1 class="page-header">
			<?php echo dico("mon_profil",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("mon_profil",$_SESSION['langue']); ?>
				
			</li>
		</ol>
		
		<?php 
		
		foreach($user as $row)
		{
		
		?>
		
		<!-- Infos générales-->
			<form action="<?php echo site_url('pages/edit_infos_generales/'.$_SESSION['User']->id_agent.'?langue='.$_SESSION['langue']);?>" method="post">
					
				<fieldset>
				<legend><h2><?php echo dico("infos_generales",$_SESSION['langue']); ?>:</h2></legend>
					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputregistre_id"><?php echo dico("registre_id",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="registre_id" id="inputregistre_id" class="form-control" value="<?php echo $row->registre_id;?>"  disabled="disabled">
				</div>
			</div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputnom"><?php echo dico("nom",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="nom" id="inputnom" class="form-control" value="<?php echo $row->nom;?>"  disabled="disabled"></div></div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputprenom"><?php echo dico("prenom",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="prenom" id="inputprenom" class="form-control" value="<?php echo $row->prenom;?>"  disabled="disabled"></div></div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputemail"><?php echo dico("email",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="email" id="inputemail" class="form-control" value="<?php echo $row->email;?>"  disabled="disabled"></div></div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputmobile_pro"><?php echo dico("mobile_pro",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="mobile_pro" id="inputmobile_pro" class="form-control" value="<?php echo $row->mobile_pro;?>"  disabled="disabled"></div></div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputlangue"><?php echo dico("langue",$_SESSION['langue']);?> : </label>
				<div class="col-sm-10">
				<input type="text" name="langue" id="inputlangue" class="form-control" value="<?php echo $row->langue;?>"  disabled="disabled"></div></div>					
			<div class="form-group row ">
				<label class="col-sm-2" for="inputpersonne_confiance"><?php echo dico("personne_confiance",$_SESSION['langue']);?> : </label>
				<?php
				if($_SESSION['User']->personne_confiance == 0)
				{
					$checked='';
				}
				else
				{
					$checked='checked';
				}
				?>
				<div class="col-sm-10">
					<input type="hidden" name="personne_confiance" id="inputpersonne_confiance" value=0 >
					<input type="checkbox" name="personne_confiance" value="1" <?php echo $checked;?> disabled="disabled">
				</div>
			</div>					
					<input type="hidden" name="id_agent" value="<?php echo $_SESSION['User']->id_agent;?>" >					
					<input type="hidden" name="modif_date" value="" >					
					<input type="hidden" name="modif_user" value="<?php echo $_SESSION['User']->login_nt;?>" >				
					<!--<div class="form-group row">        
				  <div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>
					
				  </div>
				</div>-->
					
				</fieldset>
			</form>
		<?php
		}//end foreach user
		?>
		<hr>
		<!-- Fonction(s), coordonnées et disponibilités -->
			<h2><?php echo dico("coordonnees_dispos",$_SESSION['langue']); ?>:</h2>
		<?php
		if(!empty($contrats))
		{
				$titre_contrat='';
				//print_r($contrats);
				foreach($contrats as $k=>$v)
				{
				?>
					<?php 
					$titre_contrat='';
					
					if($v->label_fonc==null)
					{
						$titre_contrat.='';
					}
					else
					{
						$titre_contrat.=$v->label_fonc.' - ';
					}
					
					if($v->label_dep==null)
					{
						$titre_contrat.=$v->label_hors_dep;
					}
					else
					{
						$titre_contrat.=$v->label_dep;
					}
					
					
					if($v->label_ser==null)
					{
						$titre_contrat.='';
					}
					else
					{
						$titre_contrat.='/'.$v->label_ser;
					}
					
					if($v->label_cel==null)
					{
						$titre_contrat.='';
					}
					else
					{
						$titre_contrat.='/'.$v->label_cel;
					}
					$titre_contrat.="\n";
					
					?>
					<form action="<?php echo site_url('pages/edit_infos_tel/'.$v->id_contrat.'?langue='.$_SESSION['langue']);?>" method="post">
					<fieldset>
					<legend class="text-grey-blue"><?php echo $titre_contrat;?></legend>
						<!-- tel 1-->
						<div class="form-group row ">
							<label class="col-sm-2" for="inputtel_1"><?php echo dico("tel_1",$_SESSION['langue']);?> : </label>
							<div class="col-sm-10">
							<input type="text" name="tel_1" id="inputtel_1" class="form-control" value="<?php echo $v->tel_1;?>"  disabled="disabled">
							</div>
						</div>	
						<!-- Comments Horaire tel 1-->
						<div class="form-group row ">
							<label class="col-sm-2" for="inputhoraire_appel_tel1"><?php echo dico("horaire_appel",$_SESSION['langue']);?> : </label>
							<div class="col-sm-10">
							<input type="text" name="horaire_appel_tel1" id="inputhoraire_appel_tel1" class="form-control" placeholder="<?php echo dico("exemple_commentaire_horaire_appel",$_SESSION['langue']);?>" value="<?php echo $v->horaire_appel_tel1;?>">
							</div>
						</div>	
						<!-- tel 2-->
						<div class="form-group row ">
							<label class="col-sm-2" for="inputtel_2"><?php echo dico("tel_2",$_SESSION['langue']);?> : </label>
							<div class="col-sm-10">
							<input type="text" name="tel_2" id="inputtel_2" class="form-control" value="<?php echo $v->tel_2;?>"  disabled="disabled">
							</div>
						</div>	
						<!-- Comments Horaire tel 2-->
						<div class="form-group row ">
							<label class="col-sm-2" for="inputhoraire_appel_tel2"><?php echo dico("horaire_appel",$_SESSION['langue']);?> : </label>
							<div class="col-sm-10">
							<input type="text" name="horaire_appel_tel2" id="inputhoraire_appel_tel2" class="form-control" placeholder="<?php echo dico("exemple_commentaire_horaire_appel",$_SESSION['langue']);?>" value="<?php echo $v->horaire_appel_tel2;?>">
							</div>
						</div>	
						
						<input type="hidden" name="modif_date" id="inputmodif_date" class="form-control" value="<?php echo $v->modif_date;?>">
						<input type="hidden" name="modif_user" id="inputmodif_user" class="form-control" value="<?php echo $v->modif_user;?>">	
						<input type="hidden" name="id_contrat" id="inputid_contrat" class="form-control" value="<?php echo $v->id_contrat;?>">
						
					<div class="form-group row">        
					  <div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>
						
					  </div>
					</div>
					</form>
					</fieldset>
				<?php
				}//end foreach contrats
			}//end if		
					?>
	</div>	<!-- end .col -->		
</div>	<!-- end .row -->	
<script>
	window.setTimeout(function() {
    $("p.alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
<?php unset($_SESSION['flash_message']);?>
</script>
