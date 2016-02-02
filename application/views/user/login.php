<?php 

//require_once APPPATH. '/tools/function_dico.php';
?>
<div class="text-center">
	<div class="logo-center">
		<img src="<?php echo img_url('logo.png');?>" class="thumbnail">
	</div>
	<h1><?php echo dico("connexion_intranet","F").'/'.dico("connexion_intranet","N");?></h1>

</div>


<hr>

	<form action="" method="post">
		<div class="form-group row">
		<label class="col-sm-2">
			<?php echo dico('nom_utilisateur','F').' / '.dico('nom_utilisateur','N'); ?> :</label>
			<div class="col-sm-10">
				<input type="text" name="login" class="form-control" value="<?php echo set_value('login'); ?>" />
			</div>
		</div>
		<?php echo form_error('login'); ?>
		<div class="form-group row">
			<label class="col-sm-2">
			<?php echo dico('mot_de_passe','F').' / '.dico('mot_de_passe','N');?> : </label>
			<div class="col-sm-10">
				<input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" />
			</div>
			
		</div>
		<?php echo form_error('password'); ?>
		
		
		<div class="form-group row">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-primary"><?php echo dico('se_connecter','F').' / '.dico('se_connecter','N');?></button>
			
		  </div>
		</div>
		<?php
		if(isset($flash_message))
		{
		?>
		<p class="alert alert-danger has-error"><?php echo $flash_message;?></p>
		<?php
		}
		?>
	</form>

