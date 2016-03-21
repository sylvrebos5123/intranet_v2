<?php 

//$_SESSION['langue']=$_GET['langue'];
?>
<!-- start navigation, tag end in sidebar.php -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

	<div class="color-line"></div>
	
	<div class="container-fluid">
<!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><span class="visible-xs">CPAS Intranet OCMW</span></a>
				
			</div>
			<form action="<?php echo site_url('pages/recherche_articles/?langue='.$_SESSION['langue']);?>" method="post" class="navbar-form inline-form navbar-right">
				<div class="form-group input-group">
				   <input type="search" class="input-md form-control" name="search" id="inputsearch" value="" placeholder="<?php echo dico('rechercher_article',$_SESSION['langue']);?>">
				  <?php //echo $this->Form->input('search','',array('type'=>'search','placeholder'=> dico('rechercher_article',$_SESSION['langue']))); ?>
				  <span class="input-group-btn"><button type="submit" class="btn btn-default btn-md"><span class="glyphicon glyphicon-search"></span> </button></span>
				</div>
			</form>

			
			<!-- Top Menu Items -->
			
            <ul class="nav navbar-right top-nav">
                <?php
                foreach($_SESSION['Contrats'] as $item){

                    if($item->id_ser == INFORMATIQUE)
                    {
                ?>
                        <li>

                            <a href="<?php echo site_url('pages/outil_admin?langue='.$_SESSION['langue']);?>" class="dropdown-toggle network" data-toggle="tooltip" data-placement="bottom" title="<?php echo dico('outil_admin',$_SESSION['langue']);?>"><i class="fa fa-users" ></i> </a>

                        </li>
                <?php
                    }
                }
                ?>
				<li class="dropdown">
					<a href="#" class="my-tooltip dropdown-toggle urgence" data-toggle="dropdown" data-placement="bottom" title="<?php echo dico('numeros_urgence',$_SESSION['langue']);?>"><i class="fa fa-fw fa-phone-square"></i><b class="caret"></b></a>
					<ul class="dropdown-menu message-dropdown">
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('stewards',$_SESSION['langue']);?> :</strong> 0489/31 65 41 - **125</a>
						</li>
					
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('num_urgence',$_SESSION['langue']);?> :</strong> 112</a>
						</li>
						
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('police',$_SESSION['langue']);?> :</strong> 02/279 86 10</a>
						</li>
						
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('dispatch',$_SESSION['langue']);?> :</strong> 0489/75 47 39 - **123</a>
						</li>
						
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('messager',$_SESSION['langue']);?> : </strong>0489/86 77 28 - **124</a>
						</li>
						
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('travaux',$_SESSION['langue']);?> : </strong>02/641 55 21</a>
						</li>
						
						<li class="message-preview">
							<a href="#"><strong><?php echo dico('garde',$_SESSION['langue']);?> : </strong>0495/66 82 31</a>
						</li>
					</ul>
				</li>
				
				<li>
					
                    <a href="<?php echo site_url('pages/annuaire?langue='.$_SESSION['langue']);?>" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="<?php echo dico('consulter_annuaire',$_SESSION['langue']);?>"><i class="fa fa-book" ></i> </a>
                    
                </li>
				
				<li>
					
                    <a href="<?php echo site_url('organigramme/index?langue='.$_SESSION['langue']);?>" class="dropdown-toggle" data-toggle="tooltip" data-placement="bottom" title="<?php echo dico('voir_organigramme_cpas',$_SESSION['langue']);?>"><i class="fa fa-sitemap" ></i> </a>
                    
                </li>
                <li class="dropdown">
                    <a href="#" class="my-tooltip dropdown-toggle" data-toggle="dropdown" data-placement="bottom" title="<?php echo dico('mes_rappels',$_SESSION['langue']);?>"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    
					<ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <!--<span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>-->
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                    </ul>
					
                </li>
				
				<li class="dropdown">
					
                    <a href="#" class="my-tooltip dropdown-toggle" data-toggle="dropdown" data-placement="bottom" title="<?php echo dico('modifier_langue',$_SESSION['langue']);?>"><i class="fa fa-flag" ></i>  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li >
                            <a href="?langue=F">
                                <img src="<?php echo img_url('fr.gif');?>">&nbsp; <?php echo dico('francais',$_SESSION['langue']);?>
                            </a>
                        </li>
						<li class="divider"></li>
						 <li >
                            <a href="?langue=N">
                                <img src="<?php echo img_url('nl.gif');?>">&nbsp; <?php echo dico('neerlandais',$_SESSION['langue']);?>
                            </a>
                        </li>
					</ul>
                </li>
				
                <li class="dropdown">
                    <a href="#" class="my-tooltip dropdown-toggle" data-toggle="dropdown" data-placement="bottom" title="<?php echo dico('mes_parametres',$_SESSION['langue']);?>"><i class="fa fa-user"></i> <?php echo $_SESSION['User']->prenom.' '.$_SESSION['User']->nom;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url('pages/profil?langue='.$_SESSION['langue']);?>"><i class="fa fa-fw fa-user"></i> <?php echo dico('mon_profil',$_SESSION['langue']);?></a>
                        </li>
						
						
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url('user/logout');?>"><i class="fa fa-fw fa-power-off"></i> <?php echo dico('deconnexion',$_SESSION['langue']);?></a>
                        </li>
                    </ul>
                </li>
			</ul>
			
	</div>
<!--</nav>  A enlever-->