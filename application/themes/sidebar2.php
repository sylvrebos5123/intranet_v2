<div class="collapse navbar-collapse navbar-ex1-collapse">
<ul id="accordion" class="accordion nav navbar-nav side-nav ">
  <li class="hidden-xs">
	<a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>"><img src="<?php echo img_url('logo_site.png');?>" title="Retour page d'accueil" height="95px"></a>
 </li>
 
  <!--<li>
		<a href="<?php echo site_url('pages/index?langue='.$_SESSION['langue']);?>" class="link"><i class="fa fa-dashboard"></i> Accueil</a>
  </li>-->
  
<?php 

//lecture menu

 $menu=$this->db->select('*')
				->from('intranet_v2_menu')
				->order_by('menu_order',' ASC')
				->get()
				->result();
//print_r($menu);

foreach($menu as $k=>$v)
{
	//echo $v->{'libelle_'.$_SESSION['langue']};
	$href='';
	$chevron_down='';
	
	if($v->href =='')
	{
		$href='';
		$chevron_down=' <i class="fa fa-chevron-down"></i>';
	}
	else
	{
		$href='href="'.site_url($v->href.'?langue='.$_SESSION['langue']).'"';
		$chevron_down='';
	}
?>	
	<li>
		<a <?php echo $href;?> class="link"><i class="fa <?php echo $v->icon;?>"></i>
			<?php 
			echo $v->{'libelle_'.$_SESSION['langue']};
			echo $chevron_down;
			?>
		</a>
		<?php
		//s'il y a un menu déroulant
		if($chevron_down!='')
		{
			//lecture sous-menu
			$sous_menu=$this->db->select('*')
				->from('intranet_v2_sous_menu')
				->where(array('id_menu' => $v->id_menu))
				->order_by('order_list',' ASC')
				->get()
				->result();
			
			
			//lecture droits d'accès pour les applis
			$agents_applis=$this->db->select('*')
				->from('cpas_agents_applis')
				->where(array('id_agent' => $_SESSION['User']->id_agent))
				->get()
				->result();
			
			//print_r($sous_menu);
		?>
		<ul class="submenu">
		<?php
			foreach($sous_menu as $k=>$w)
			{
				if($w->id_menu==2) //menu Commandes
				{
					foreach($agents_applis as $k2=>$w2)
					{
						if($w->id_sous_menu == $w2->id_appli) //vérification droit par r/aux applis
						{
							if(empty($w->lien))
							{
								$lien='#';
							}
							else
							{
								$lien=$w->lien.'?langue='.$_SESSION['langue'];
							}
					?>
						<li>
							<a href="<?php echo $lien;?>" target="_blank">
								<?php echo $w->{'sous_menu_'.$_SESSION['langue']};?>
							</a>
						</li>
			<?php
						}//fin if
					}//fin foreach agents_applis
				}
				
				if($w->id_menu==1) //menu Agendas
				{
					if(empty($w->lien))
					{
						$lien='#';
					}
					else
					{
						$lien=$w->lien.'?langue='.$_SESSION['langue'];
					}
					?>
						<li>
							<a href="<?php echo $lien;?>">
								<?php echo $w->{'sous_menu_'.$_SESSION['langue']};?>
							</a>
						</li>
					<?php
				}
			}
		?>
		</ul>
		<?php
		}
		?>
		
	  </li>
<?php
} // fin foreach
?>
	<li>
		
		<a href="<?php echo site_url('pages/archives?langue='.$_SESSION['langue']);?>" class="link">
		<i class="fa fa-archive"></i>	<?php echo dico('archives',$_SESSION['langue']);?>
		</a>
	</li>
  
	<hr>
	<li><a href="#" onclick="fOpenExplorer('x:');"><?php echo dico('mon_service',$_SESSION['langue']);?></a></li>
	<li><a href="https://webmail.irisnet.be/owa" target="_blank"><?php echo dico('mandataires',$_SESSION['langue']);?></a></li>
	<li><a href="<?php echo site_url('pages/archives?langue='.$_SESSION['langue']);?>" target="_blank"><?php echo dico('archives',$_SESSION['langue']);?></a></li>
  <!--<li>
    <a class="link"><i class="fa fa-fw fa-calendar"></i>Agendas<i class="fa fa-chevron-down"></i></a>
    <ul class="submenu">
		<li >
			<a id="mon_agenda" data-toggle="modal" href="#infos">Mon agenda</a>  
		</li>
		<li>
			<a id="agenda_officiel" data-toggle="modal" href="#infos">Agenda officiel</a>
		</li>
		 <li>
			<a href="#">Notre E-Organizer</a>
		</li>
    </ul>
  </li>
  <li>
    <a class="link"><i class="fa fa-fw fa-shopping-cart"></i>Commandes<i class="fa fa-chevron-down"></i></a>
    <ul class="submenu">
	
  
</ul>
</div>
</nav>