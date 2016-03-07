<div class="row">
	<div class="col-lg-12">

		<h1 class="page-header">
			<?php echo dico("order_cartridge",$_SESSION['langue']); ?>
		</h1>
		<!--<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("order_cartridge",$_SESSION['langue']); ?>
			</li>
		</ol>-->
	</div>
</div>

<form action="<?php echo site_url('pages/edit_order_cartridge/'.$_SESSION['User']->id_agent.'?langue='.$_SESSION['langue']);?>" method="post">
					
	<fieldset>
		<!--<legend><h2><?php echo dico("order_cartridge",$_SESSION['langue']); ?>:</h2></legend>-->
					
		<div class="form-group row">
			<label class="col-sm-2" for="inputagent_request"><?php echo dico("agent_request",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="agent_request" id="inputagent_request" class="form-control" value="<?php echo $_SESSION['User']->login_nt;?>"  disabled="disabled">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputdate_order"><?php echo dico("date_order",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="date_order" id="inputdate_order" class="form-control" value="">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputnom"><?php echo dico("nom",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="nom" id="inputnom" class="form-control" value="<?php echo $_SESSION['User']->nom;?>"  disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2" for="inputprenom"><?php echo dico("prenom",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="prenom" id="inputprenom" class="form-control" value="<?php echo $_SESSION['User']->prenom;?>"  disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2" for="inputemail"><?php echo dico("email",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="email" id="inputemail" class="form-control" value="<?php echo $_SESSION['User']->email;?>"  disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2" for="inputmobile_pro"><?php echo dico("mobile_pro",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="mobile_pro" id="inputmobile_pro" class="form-control" value="<?php echo $_SESSION['User']->mobile_pro;?>"  disabled="disabled">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2" for="inputlangue"><?php echo dico("langue",$_SESSION['langue']);?> : </label>
			<div class="col-sm-10">
				<input type="text" name="langue" id="inputlangue" class="form-control" value="<?php echo $_SESSION['User']->langue;?>"  disabled="disabled">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputcolor_cyan"><?php echo dico("color_cyan",$_SESSION['langue']);?> : </label>

			<div class="col-sm-10">
				<input type="hidden" name="color_cyan" id="inputcolor_cyan" value=0 >
				<input type="checkbox" name="color_cyan" value="1" >
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputcolor_magenta"><?php echo dico("color_magenta",$_SESSION['langue']);?> : </label>

			<div class="col-sm-10">
				<input type="hidden" name="color_magenta" id="inputcolor_magenta" value=0 >
				<input type="checkbox" name="color_magenta" value="1">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputcolor_yellow"><?php echo dico("color_yellow",$_SESSION['langue']);?> : </label>

			<div class="col-sm-10">
				<input type="hidden" name="color_yellow" id="inputcolor_yellow" value=0 >
				<input type="checkbox" name="color_yellow" value="1">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputcolor_black"><?php echo dico("color_black",$_SESSION['langue']);?> : </label>

			<div class="col-sm-10">
				<input type="hidden" name="color_black" id="inputcolor_black" value=0 >
				<input type="checkbox" name="color_black" value="1">
			</div>
		</div>
				<input type="hidden" name="id_agent" value="<?php echo $_SESSION['User']->id_agent;?>" >
				<input type="hidden" name="modif_date" value="">
				<input type="hidden" name="modif_user" value="<?php echo $_SESSION['User']->login_nt;?>" >
		<div class="form-group row">
			  <div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>

			  </div>
		</div>
					
	</fieldset>
</form>