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
            <?php echo dico("photos_annuaire",$_SESSION['langue']); ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo dico("photos_annuaire",$_SESSION['langue']); ?>

            </li>
        </ol>

        <!-- form search agents -->
        <form action="<?php echo site_url('pages/photos_annuaire?langue='.$_SESSION['langue']);?>" method="post">
            <div class="form-group row ">
                <label for="inputagent" class="col-sm-2"><?php echo dico("quel_agent",$_SESSION['langue']); ?></label>

                <div class="col-sm-8">
                    <select name="inputagent" id="inputagent" class="form-control">
                        <option value="">---</option>
                        <?php
                        foreach($list_agents as $k_agents=>$v_agents)
                        {
                            if($id_agent==$v_agents->id_agent)
                            {
                                $selected='selected';
                            }
                            else
                            {
                                $selected='';
                            }
                            ?>

                            <option value="<?php echo $v_agents->id_agent;?>" <?php echo $selected;?>><?php echo $v_agents->nom.' '.$v_agents->prenom;?></option>
                            <?php
                        }
                        ?>
                    </select>

                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>
                </div>
            </div>
        </form>

        <form action="<?php echo site_url('pages/photos_annuaire?langue='.$_SESSION['langue']);?>" method="post" enctype="multipart/form-data">
            <div class="form-group row ">
                <label for="inputagent" class="col-sm-2"><?php echo dico("quelle_photo",$_SESSION['langue']); ?></label>
                <div class="col-sm-8">
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
            </div>
            <!--<div class="form-group row ">
                <label for="inputagent" class="col-sm-2"><?php echo dico("quelle_photo",$_SESSION['langue']); ?></label>
                <div class="col-sm-8">
                    <input type="text" name="photo_name" id="photo_name" class="form-control">
                </div>
            </div>-->
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </form>
        <?php
        print_r($_FILES);
        echo dirname(__FILE__);
        ?>
    </div>
</div>