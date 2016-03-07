<div class="row">
	<div class="col-lg-12">

		<h1 class="page-header">
			<?php echo dico("order_cartridge",$_SESSION['langue']); ?>
		</h1>
		<ol class="breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
			</li>
			<li class="active">
				<i class="fa fa-file"></i> <?php echo dico("order_cartridge",$_SESSION['langue']); ?>
			</li>
		</ol>
	</div>
</div>

<form action="<?php echo site_url('pages/edit_order_cartridge/'.$_SESSION['User']->id_agent.'?langue='.$_SESSION['langue']);?>" method="post">
					
	<fieldset>
		<!--<legend><h2><?php echo dico("order_cartridge",$_SESSION['langue']); ?>:</h2></legend>-->
					
		<div class="form-group row">
			<label class="col-sm-2" for="inputid_agent"><?php echo dico("pour_qui",$_SESSION['langue']);?> </label>
			<div class="col-sm-10">
				<input type="text" name="id_agent" id="inputid_agent" class="form-control" value="<?php echo $_SESSION['User']->nom.' '.$_SESSION['User']->prenom;?>">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputdate_order"><?php echo dico("pour_quand",$_SESSION['langue']);?> </label>
			<div class="col-sm-10">
				<input type="date" name="date_order" id="inputdate_order" data-date="" data-date-format="DD-MMMM-YYYY" class="form-control" value="">

			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2" for="inputid_stock"><?php echo dico("quelle_imprimante",$_SESSION['langue']);?> </label>
			<div class="col-sm-10">
				<input type="text" name="id_stock" id="inputid_stock" class="form-control" value="">
			</div>
		</div>
		

		<h2><?php echo dico("choix_cartouches",$_SESSION['langue']);?> : </h2>

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