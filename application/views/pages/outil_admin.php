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
            <?php echo dico("outil_admin",$_SESSION['langue']); ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><?php echo dico("accueil",$_SESSION['langue']); ?></a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo dico("outil_admin",$_SESSION['langue']); ?>

            </li>
        </ol>
        <?php
        //echo $_POST['inputagent'];
        //echo $id_agent;
        //print_r($_SESSION['Apps']);
        //print_r($this->input->get_cookie("Apps"));
//        print_r($this->input->cookie('Apps',true));
        //echo $_SESSION['Apps'][0]->id_agent;
        /*foreach($_SESSION['Apps'] as $item)
        {
            echo $item->id_appli.'<br>';
        }*/
        ?>
        <!-- form search agents -->
        <form action="<?php echo site_url('pages/outil_admin?langue='.$_SESSION['langue']);?>" method="post">
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

        <hr>
        <?php
        // If agent is selected
        if(!empty($id_agent))
        {
            foreach($agent as $k=>$v)
            {
        ?>
            <!-- Infos générales-->
            <form action="<?php echo site_url('pages/edit_infos_generales/'.$v->id_agent.'?langue='.$_SESSION['langue']);?>" method="post">

                <fieldset>
                    <legend><h2><?php echo dico("donnees_generales",$_SESSION['langue']); ?>:</h2></legend>

                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputregistre_id"><?php echo dico("registre_id",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="registre_id" id="inputregistre_id" class="form-control" value="<?php echo $v->registre_id;?>"  disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputnom"><?php echo dico("nom",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="nom" id="inputnom" class="form-control" value="<?php echo $v->nom;?>"  disabled="disabled"></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputprenom"><?php echo dico("prenom",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="prenom" id="inputprenom" class="form-control" value="<?php echo $v->prenom;?>"  disabled="disabled"></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputlogin_nt"><?php echo dico("login_nt",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="login_nt" id="inputlogin_nt" class="form-control" value="<?php echo $v->login_nt;?>" ></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputemail"><?php echo dico("email",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="inputemail" class="form-control" value="<?php echo $v->email;?>" ></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputmobile_pro"><?php echo dico("mobile_pro",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="mobile_pro" id="inputmobile_pro" class="form-control" value="<?php echo $v->mobile_pro;?>"  ></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputlangue"><?php echo dico("langue",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                            <input type="text" name="langue" id="inputlangue" class="form-control" value="<?php echo $v->langue;?>"  disabled="disabled"></div></div>
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputpersonne_confiance"><?php echo dico("personne_confiance",$_SESSION['langue']);?> : </label>
                        <?php
                        if($v->personne_confiance == 0)
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
                            <input type="checkbox" name="personne_confiance" value="1" <?php echo $checked;?> >
                        </div>
                    </div>
                    <input type="hidden" name="id_agent" value="<?php echo $v->id_agent;?>" >
                    <input type="hidden" name="modif_date" value="" >
                    <input type="hidden" name="modif_user" value="<?php echo $v->login_nt;?>" >
                    <input type="hidden" name="app" id="app" value="outil_admin" >
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>

                        </div>
                    </div>

                </fieldset>
            </form>
        <?php
            } //end foreach $agent
        ?>


    <hr>
    <!-- Fonction(s), coordonnées et disponibilités -->
    <h2><?php echo dico("gestion_tel",$_SESSION['langue']); ?>:</h2>
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
                        <input type="text" name="tel_1" id="inputtel_1" class="form-control" value="<?php echo $v->tel_1;?>"  >
                        </div>
                    </div>
                    <!-- Comments Horaire tel 1-->
                    <!--<div class="form-group row ">
                        <label class="col-sm-2" for="inputhoraire_appel_tel1"><?php echo dico("horaire_appel",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                        <input type="text" name="horaire_appel_tel1" id="inputhoraire_appel_tel1" class="form-control" placeholder="<?php echo dico("exemple_commentaire_horaire_appel",$_SESSION['langue']);?>" value="<?php echo $v->horaire_appel_tel1;?>">
                        </div>
                    </div>-->
                    <!-- tel 2-->
                    <div class="form-group row ">
                        <label class="col-sm-2" for="inputtel_2"><?php echo dico("tel_2",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                        <input type="text" name="tel_2" id="inputtel_2" class="form-control" value="<?php echo $v->tel_2;?>"  >
                        </div>
                    </div>
                    <!-- Comments Horaire tel 2-->
                    <!--<div class="form-group row ">
                        <label class="col-sm-2" for="inputhoraire_appel_tel2"><?php echo dico("horaire_appel",$_SESSION['langue']);?> : </label>
                        <div class="col-sm-10">
                        <input type="text" name="horaire_appel_tel2" id="inputhoraire_appel_tel2" class="form-control" placeholder="<?php echo dico("exemple_commentaire_horaire_appel",$_SESSION['langue']);?>" value="<?php echo $v->horaire_appel_tel2;?>">
                        </div>
                    </div>-->

                    <input type="hidden" name="modif_date" id="inputmodif_date" class="form-control" value="<?php echo $v->modif_date;?>">
                    <input type="hidden" name="modif_user" id="inputmodif_user" class="form-control" value="<?php echo $v->modif_user;?>">
                    <input type="hidden" name="id_contrat" id="inputid_contrat" class="form-control" value="<?php echo $v->id_contrat;?>">
                    <input type="hidden" name="id_agent" id="inputid_agent" class="form-control" value="<?php echo $v->id_agent;?>">
                    <input type="hidden" name="app" id="app" value="outil_admin" >
                <div class="form-group row">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>

                  </div>
                </div>

                </fieldset>
                </form>
            <?php
            }//end foreach contrats
            ?>
        <hr>
        <!-- Access apps-->
        <form action="<?php echo site_url('pages/edit_access_applis/'.$id_agent.'?langue='.$_SESSION['langue']);?>" method="post">
            <div class="form-group row ">
            <fieldset>
                <legend><h2><?php echo dico("accès_applis",$_SESSION['langue']); ?>:</h2></legend>
                <?php

                //foreach($user as $row)
                //{
                $sous_menu='sous_menu_'.$_SESSION['langue'];
                $checked='';
                //print_r($applis_par_agent);
                //applications
                foreach($applis as $k=>$v)
                {
                    foreach($applis_par_agent as $k_agents=>$v_agents)
                    {
                        if($v_agents->id_appli==$v->id_sous_menu)
                        {
                            //echo 'coucou';
                            $checked='checked';
                        }

                    } //$applis_par_agent
                ?>
                    <input type="checkbox" name="id_appli[]" value="<?php echo $v->id_sous_menu;?>" <?php echo $checked;?> >
                    <?php echo $v->$sous_menu.'<br>';?>
                <?php
                    $checked='';
                } //$applis

                ?>

            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><?php echo dico("valider",$_SESSION['langue']);?></button>

                </div>
            </div>
            </fieldset>
        </form>

        <?php
        }//end if

    } // end if (!empty $_POST)

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
