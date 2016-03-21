
<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo dico("bonjour",$_SESSION['langue']).' ';
							if(empty($_SESSION['User']->prenom) OR $_SESSION['User']->prenom=='/')
							{
								echo $_SESSION['User']->nom;
							}
							else
							{
								echo $_SESSION['User']->prenom;
							}
							
							?> ! 
							<small><?php echo dico("bienvenue_page_intranet",$_SESSION['langue']); ?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <?php echo dico("accueil",$_SESSION['langue']); ?>
                            </li>
                        </ol>
                    </div>
                </div>
				
				<?php
					
					$i=0;
					$panel_color='panel-yellow';
					//print_r($articles);
					//print_r($_SESSION['Contrats']);

				?>
					<div class="row">
						<div class="col-lg-6">
					
						<?php
						
						foreach($articles as $k => $v)
						{
							$i++;
							
							switch($i)
							{
								case 1: $panel_color='panel-yellow';
										break;
								case 2: $panel_color='panel-orange';
										break;
								case 3: $panel_color='panel-red';
										break;
								default: $panel_color='panel-yellow';
										break;
							}
						?>
						
							<div class="panel panel-default <?php echo $panel_color;?>">
								<div class="panel-heading">
									<h4><?php echo $v->{'titre_article_'.$_SESSION['langue']};?></h4>
								</div>
								<div class="panel-body">
									<img src="<?php echo 'http://intranet.cpasixelles.be/images/articles/'.$v->url_photo;?>" class="thumbnail pull-left">
									<p><strong><?php echo $v->{'sous_titre_'.$_SESSION['langue']};?></strong></p>
									<p><?php echo $v->{'chapeau_'.$_SESSION['langue']};?></p>
									<div class="text-right">
										<a href="<?php echo site_url("pages/view/{$v->id_article}?langue=".$_SESSION['langue']); ?>"><?php echo dico("lire_la_suite",$_SESSION['langue']);?> <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								
							</div>
						
						<?php

						}
						?>
						</div><!-- /.col -->
						
						
						<!--Evènements-->
						<div class="col-lg-6">
						  <div class="panel panel-default panel-darkred">
							<div class="panel-heading">
								
								<h4><?php echo dico("evenements",$_SESSION['langue']);?></h4>
							</div>
							<div class="panel-body">
								<?php
								if(!empty($a_rdv))
								{
									foreach($a_rdv as $k=>$v) //result data
									{
										if($v['OU']=='')
										{
											$ou='';
										}
										else
										{
											$ou=' - '.$v['OU'];
										}
										
										echo '<p>'.$v['SUJET'].$ou.' - '.$v['START_DATE'].' - '.$v['START_HEURE'].'</p>';
										
										
									}
								}
								else
								{
								echo dico('no_event',$_SESSION['langue']);
								}
								//print_r($a_rdv);
								?>
							
							</div>
						  </div>
						</div>
						
						<!--Notes de service-->
						<div class="col-lg-6">
						  <div class="panel panel-default">
							<div class="panel-heading">
								
								<h4><?php echo dico("notes_service",$_SESSION['langue']);?></h4>
							</div>
							<div class="panel-body">
								<?php //print_r($notes_service); 
								
								foreach($notes_service as $k => $v)
								{
								?>
									<p>
									
										<a href="http://intranet.cpasixelles.be/gestion_agent/archives/archives/<?php echo $v->{'url_fichier_'.$_SESSION['langue']};?>" target="_blank">
										<?php echo $v->{'sous_titre_'.$_SESSION['langue']};?>
										</a>
									</p>
								<?php
								}
								?>
							
							</div>
						  </div>
						  
						</div>
						<!--Actualités-->
						<div class="col-lg-6">
						  <div class="panel panel-default">
							<div class="panel-heading">
								
								<h4><?php echo dico("actualites",$_SESSION['langue']);?></h4>
							</div>
							<div class="panel-body">
								<?php
								foreach($actualites as $k => $v)
								{
								?>
									<p>
										<a href="<?php echo site_url("pages/view/{$v->id_article}?langue=".$_SESSION['langue']); ?>">
											<?php echo $v->{'titre_article_'.$_SESSION['langue']};?>
										</a>
									</p>
								<?php
								}
								?>
							
							</div>
						  </div>
						  
						</div>
					</div> <!-- row -->
					
				