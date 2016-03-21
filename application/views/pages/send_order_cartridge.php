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

<form action="<?php //echo site_url('pages/edit_order_cartridge/'.$_SESSION['User']->id_agent.'?langue='.$_SESSION['langue']);?>" method="post">

    <fieldset>
        <!--<legend><h2><?php echo dico("order_cartridge",$_SESSION['langue']); ?>:</h2></legend>-->

        <div class="form-group row">
            <label class="col-sm-2" for="inputid_agent_request"><?php echo dico("pour_qui",$_SESSION['langue']);?> </label>
            <div class="col-sm-10">
               <!--<input type="text" list="list_agents" class="form-control" value="<?php echo $_SESSION['User']->nom.' '.$_SESSION['User']->prenom;?>">
                -->

                <select name="id_agent_request" id="inputid_agent_request" class="form-control">

                <?php

                foreach($agents as $k=>$v)
                {
                    if($v->id_agent==$_SESSION['User']->id_agent)
                    {
                        $selected="selected";
                    }
                    else
                    {
                        $selected="";
                    }
                ?>
                    <option value="<?php echo $v->id_agent?>" <?php echo $selected;?>><?php echo $v->nom.' '.$v->prenom;?></option>

                <?php
                }
                ?>
                </select>
            </div>
        </div>

       <!-- <div class="form-group row">
            <label class="col-sm-2" for="inputdate_order"><?php echo dico("pour_quand",$_SESSION['langue']);?> </label>
            <div class="col-sm-10">
                <input type="date" name="date_order" id="inputdate_order" data-date="" data-date-format="DD-MMMM-YYYY" class="form-control" value="">

            </div>
        </div>
        <?php echo form_error('date_order'); ?>-->
        <div class="form-group row">
            <label class="col-sm-2" for="inputid_stock"><?php echo dico("quelle_imprimante",$_SESSION['langue']);?> </label>
            <div class="col-sm-10">
                <input type="text" name="id_stock" id="inputid_stock" class="form-control" value="<?php echo set_value('id_stock'); ?>">
            </div>
        </div>
        <?php echo form_error('id_stock'); ?>
        <hr>
        <p><strong><?php echo dico("choix_cartouches",$_SESSION['langue']);?> : </strong></p>
        <hr>
        <div class="form-group row">
            <label class="col-sm-2" for="inputcolor_cyan"><?php echo dico("color_cyan",$_SESSION['langue']);?> : </label>
            <div class="col-sm-1"><input type="checkbox" name="color[0]" value="1" <?php echo set_checkbox('color[0]', '1'); ?> /></div>

            <label class="col-sm-2" for="inputcolor_magenta"><?php echo dico("color_magenta",$_SESSION['langue']);?> : </label>
            <div class="col-sm-1"><input type="checkbox" name="color[1]" value="2" <?php echo set_checkbox('color[1]', '2'); ?> /></div>

            <label class="col-sm-2" for="inputcolor_yellow"><?php echo dico("color_yellow",$_SESSION['langue']);?> : </label>
            <div class="col-sm-1"><input type="checkbox" name="color[2]" value="3" <?php echo set_checkbox('color[2]', '3'); ?> /></div>

            <label class="col-sm-2" for="inputcolor_black"><?php echo dico("color_black",$_SESSION['langue']);?> : </label>
            <div class="col-sm-1"><input type="checkbox" name="color[3]" value="4" <?php echo set_checkbox('color[3]', '4'); ?> /></div>

        </div>
        <?php echo form_error('color[]'); ?>
        <!-- textarea comment-->
        <div class="form-group row">
            <label class="col-sm-2" for="inputcomment"><?php echo dico("comment",$_SESSION['langue']);?> : </label>
            <div class="col-sm-10">
                <textarea name="comment" id="inputcomment" class="form-control"></textarea>
            </div>
        </div>
        <input type="hidden" name="id_agent" value="<?php echo $_SESSION['User']->id_agent;?>" >
        <input type="hidden" name="date_created" value="">
        <input type="hidden" name="modif_user" value="<?php echo $_SESSION['User']->login_nt;?>" >
        <br></br>
        <!--<div class="form-group row">
            <div class="col-sm-offset-2 col-sm-10">-->
            <div>
            <button type="submit" class="center-block btn btn-primary"><?php echo dico("envoyer_commande",$_SESSION['langue']);?></button>
            </div>
        <!--
        </div>
    </div>-->

    </fieldset>

</form>
<script>
    window.setTimeout(function() {
        $("p.alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
    <?php unset($_SESSION['flash_message']);?>
</script>