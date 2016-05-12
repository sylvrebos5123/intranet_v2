<?php

class Pages extends CI_Controller
{
	private $theme = 'default';
	
	public function __construct()
	{
		parent::__construct();
		
		//	Chargement des ressources pour tout le contr�leur
		$this->load->database();
		$this->load->helper('MY_url_helper');
		$this->load->helper('assets_helper');
		$this->load->library('Layout');
		//CSS
		$this->layout->ajouter_css('datatables.min');
		$this->layout->ajouter_css('bootstrap.min');
		$this->layout->ajouter_css('sb-admin');
		//JS
		$this->layout->ajouter_js('jquery');
		$this->layout->ajouter_js('bootstrap.min');
		$this->layout->ajouter_js('my_functions');
		
	}

	public function index()
	{
		$condition=array('to_publish_flag' => 1,'order_article_1er' => 1);
		
		// Read main online articles with a limit of 3
		$data['articles'] = $this->db->select('*')
				->from('cpas_articles')
				->where($condition)
				->order_by( 'to_publish_date', 'desc')
				->limit('0','3')
				->get()
				->result();
				
		//Actualities
		$condition=array('to_publish_flag' => 1,'code_type' => 4);
		$data['actualites'] = $this->db->select('*')
				->from('cpas_articles')
				->where($condition)
				->order_by( 'to_publish_date', 'desc')
				->limit(10)
				->get()
				->result();	
				
				
		//Notes de service
		$condition=array('to_publish_flag' => 1,'code_type' => 2);
		$data['notes_service'] = $this->db->select('*')
				->from('cpas_archives')
				->where($condition)
				->order_by( 'to_publish_date', 'desc')
				->limit(10)
				->get()
				->result();	
		
		
		//events
		/*$rootpath = APPPATH.'libraries';
		include($rootpath.'/exchange/ews.php');
		include($rootpath.'/config_ews/config_ews.php');

		//agenda officiel
		$username=trim($email_array['agenda_news_F']['email']);
		$password=trim($email_array['agenda_news_F']['email_psw']);
		$start_date=date('d-m-Y');
		$end_date=date('d-m-Y',strtotime('+6 month')); */
		/* $start_date='01-01-2014';
		$end_date='31-12-2016';*/
		//$data['a_rdv'] = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,'');
		
		$this->layout->view('pages/index',$data);
	}
	
	function view($id)
	{
	
		$data['article'] = $this->db->select('*')
				->from('cpas_articles')
				->where(array('id_article' => $id))
				->get()
				->result();
		$this->layout->view('pages/view',$data);
		
	}
	
	function guides()
	{
		
		$data['guides'] = $this->db->select('*')
				->from('cpas_guides_pratiques')
				->get()
				->result();
				
		$this->layout->view('pages/guides',$data);
		
	}
	
	function applications()
	{
		
		$data['applis'] = $this->db->select('*')
						->from('intranet_v2_sous_menu')
						->join('cpas_agents_applis',' intranet_v2_sous_menu.id_sous_menu=cpas_agents_applis.id_appli')
						->where('id_menu=4 and id_agent='.$_SESSION['User']->id_agent)
						->order_by('order_list', 'asc')
						->get()
						->result();
		$this->layout->view('pages/applications',$data);		
		
	}
	
	function recherche_articles()
	{
		
		$data['resultats'] = $this->db->select('*')
				->from('cpas_articles')
				->where('code_cle like "%'.$this->input->post('search').'%"
								OR titre_article_F like "%'.$this->input->post('search').'%"
								OR sous_titre_F like "%'.$this->input->post('search').'%"
								OR titre_article_N like "%'.$this->input->post('search').'%"
								OR sous_titre_N like "%'.$this->input->post('search').'%"')
				->get()
				->result();
				
		$this->layout->view('pages/recherche_articles',$data);
		
	}
	
	function annuaire()
	{
	//Infos contract
	
		$data['contrats']=$this->db->select('cpas_agents.id_agent as id_agent,genre,url_photo,
							   id_contrat,nom,prenom,mobile_pro,email,personne_confiance,
							   cpas_contrats.id_dep,
							   cpas_contrats.tel_1,
							   cpas_contrats.tel_2,
							   cpas_contrats.horaire_appel_tel1,
							   cpas_contrats.horaire_appel_tel2,
							   cpas_hors_departements.label_'.$_SESSION['langue'].' as label_hors_dep,
							   cpas_departements.label_'.$_SESSION['langue'].' as label_dep,
							   cpas_services.label_'.$_SESSION['langue'].' as label_ser,
							   cpas_cellules.label_'.$_SESSION['langue'].' as label_cel,
							   cpas_fonctions.label_'.$_SESSION['langue'].' as label_fonc')
						->from('cpas_agents')
						->join('cpas_contrats',' cpas_agents.id_agent=cpas_contrats.id_agent')
						->join('cpas_hors_departements','cpas_contrats.id_hors_dep=cpas_hors_departements.id_hors_dep','left')
						->join('cpas_departements','cpas_contrats.id_dep=cpas_departements.id_dep','left')
						->join('cpas_services','cpas_contrats.id_ser=cpas_services.id_ser','left')
						->join('cpas_cellules','cpas_contrats.id_cel=cpas_cellules.id_cel','left')
						->join('cpas_fonctions','cpas_contrats.id_fonc=cpas_fonctions.id_fonc','left')
						->where('cpas_contrats.actif=1 AND cpas_contrats.id_dep<>5 AND cpas_contrats.id_ser<>'.PERS_CONF)
						->order_by('nom', 'asc')
						->order_by('prenom', 'asc')
						->get()
						->result();
		
		$this->layout->view('pages/annuaire',$data);	
	
	}
	
	function archives()
	{
		$this->layout->view('pages/archives');
	}

	/*Menu agendas/Agenda officiel*/
	function agenda_officiel()
	{
		$rootpath = APPPATH.'libraries';
		include($rootpath.'/exchange/ews.php');
		include($rootpath.'/config_ews/config_ews.php');

		//agenda officiel
		$username=trim($email_array['agenda_off']['email']);
		$password=trim($email_array['agenda_off']['email_psw']);
		$start_date='01-01-'.date('Y');
		$end_date='31-12-'.date('Y');
		$data['a_rdv'] = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,'');
		$this->layout->view('calendrier/agenda_officiel',$data);

	}

	/*Menu agendas/Mon agenda*/
	function mon_agenda()
	{
		$rootpath = APPPATH.'libraries';
		include($rootpath.'/exchange/ews.php');
		include($rootpath.'/config_ews/config_ews.php');

		//agenda officiel
		$username=trim($_SESSION['User']->email);
		$password=trim(base64_decode($_SESSION['User']->password_email));
		$start_date='01-01-'.date('Y');
		$end_date='31-12-'.date('Y');
		$data['a_rdv'] = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,'');
		$this->layout->view('calendrier/mon_agenda',$data);

	}

	
	function profil($id = null)
	{
		
		//Infos contract
		
		$data['contrats']=$this->db->select('id_contrat,
							   tel_1,tel_2,horaire_appel_tel1,horaire_appel_tel2,
							   cpas_contrats.modif_date as modif_date,cpas_contrats.modif_user as modif_user,
							   cpas_hors_departements.label_'.$_SESSION['langue'].' as label_hors_dep,
							   cpas_departements.label_'.$_SESSION['langue'].' as label_dep,
							   cpas_services.label_'.$_SESSION['langue'].' as label_ser,
							   cpas_cellules.label_'.$_SESSION['langue'].' as label_cel,
							   cpas_fonctions.label_'.$_SESSION['langue'].' as label_fonc')
						->from('cpas_contrats')
						->join('cpas_hors_departements','cpas_contrats.id_hors_dep=cpas_hors_departements.id_hors_dep','left')
						->join('cpas_departements','cpas_contrats.id_dep=cpas_departements.id_dep','left')
						->join('cpas_services','cpas_contrats.id_ser=cpas_services.id_ser','left')
						->join('cpas_cellules','cpas_contrats.id_cel=cpas_cellules.id_cel','left')
						->join('cpas_fonctions','cpas_contrats.id_fonc=cpas_fonctions.id_fonc','left')
						->where('id_agent='.$_SESSION['User']->id_agent.' AND cpas_contrats.actif=1 AND cpas_contrats.id_ser<>'.PERS_CONF)
						->get()
						->result();
		//print_r($_SESSION['User']);
		//print_r($_SESSION['langue']);
		
		$this->layout->view('pages/profil',$data);
		
	}


	/*Permet d'éditer les données générales d'un agent*/
	function edit_infos_generales($id = null)
	{

		//$this->db->set('registre_id',$this->input->post('registre_id'));
		//$this->db->set('nom',$this->input->post('nom'));
		//$this->db->set('prenom',$this->input->post('prenom'));
		$this->db->set('login_nt',$this->input->post('login_nt'));
		$this->db->set('email',$this->input->post('email'));
		$this->db->set('mobile_pro',$this->input->post('mobile_pro'));
		$this->db->set('personne_confiance',$this->input->post('personne_confiance'));
		//$this->db->set('modif_date',date('Y-m-d H:i:s'));
		//$this->db->set('modif_user',$_SESSION['User']->login_nt);
		$this->db->where('id_agent',$this->input->post('id_agent'));
		$this->db->update('cpas_agents');


		$this->session->set_flashdata('message',dico('infos_bien_enregistrees',$_SESSION['langue']));
		$_SESSION['flash_message'] = $this->session->flashdata('message');

		//redirect(site_url("pages/profil?langue=".$_SESSION['langue']));

		if($this->input->post('app')=='outil_admin')
		{
			redirect(site_url("pages/outil_admin/".$id."?langue=".$_SESSION['langue']));
		}
	}

	/*Permet d'éditer les infos téléphoniques du profil*/
	function edit_infos_tel($id = null)
	{
		$this->db->set('tel_1',$this->input->post('tel_1'));
		$this->db->set('tel_2',$this->input->post('tel_2'));
		$this->db->set('horaire_appel_tel1',$this->input->post('horaire_appel_tel1'));
		$this->db->set('horaire_appel_tel2',$this->input->post('horaire_appel_tel2'));
		$this->db->set('modif_date',date('Y-m-d H:i:s'));
		$this->db->set('modif_user',$_SESSION['User']->login_nt);
		$this->db->where('id_contrat',$this->input->post('id_contrat'));
		$this->db->update('cpas_contrats');
		
		
		$this->session->set_flashdata('message',dico('infos_bien_enregistrees',$_SESSION['langue']));
		$_SESSION['flash_message'] = $this->session->flashdata('message');



		if($this->input->post('app')=='outil_admin')
		{
			redirect(site_url("pages/outil_admin/".$this->input->post('id_agent')."?langue=".$_SESSION['langue']));
		}
		else
		{
			redirect(site_url("pages/profil?langue=".$_SESSION['langue']));
		}
	}

	/*Permet d'éditer les accès aux applis*/
	function edit_access_applis($id_agent)
	{
		if(!empty($id_agent))
		{
			//delete link between agent and apps
			$this->db->where('id_agent', $id_agent);
			$this->db->delete('cpas_agents_applis');
		}
			$array_applis=$this->input->post('id_appli[]');
			//print_r($id_agent);
			foreach($array_applis as $appli)
			{
				//insertion links
				$this->db->set('id_agent',$id_agent);
				$this->db->set('id_appli',$appli);
				$this->db->insert('cpas_agents_applis');

			}

		$this->session->set_flashdata('message',dico('infos_bien_enregistrees',$_SESSION['langue']));
		$_SESSION['flash_message'] = $this->session->flashdata('message');
		redirect(site_url("pages/outil_admin/".$id_agent."?langue=".$_SESSION['langue']));

	}

	/*Send order for cartridges*/
	public function send_order_cartridge()
	{

		// read list of agents
		$data['agents']=$this->db->select('cpas_agents.id_agent,nom,prenom')
            ->from('cpas_agents')
            ->join('cpas_contrats','cpas_contrats.id_agent=cpas_agents.id_agent','left')
            ->where('cpas_agents.login_nt<>"" AND cpas_contrats.actif=1 AND cpas_contrats.id_ser<>'.PERS_CONF.' AND cpas_contrats.id_ser<>'.RVA.' AND cpas_contrats.id_ser<>'.RHD)
			->order_by("nom","asc")
            ->get()
            ->result();


		$this->load->library('form_validation');
		// That method creates delimiters by default for messages errors (<p></p>).
		$this->form_validation->set_error_delimiters('<p class="alert alert-danger has-error">', '</p>');

		//	Form validation rules
		$this->form_validation->set_rules('id_agent_request',  '"id_agent_request"',  'required',array(
				'required' => 'Vous devez sélectionner un agent'));
		/*$this->form_validation->set_rules('date_order', '"date_order"', 'required',array(
				'required' => 'Vous devez sélectionner une date'));*/
		$this->form_validation->set_rules('id_stock', '"id_stock"', 'required',array(
				'required' => 'Vous devez sélectionner une imprimante'));
		$this->form_validation->set_rules('color[]', '"color"', 'required', array(
				'required' => 'Vous devez cocher au moins une couleur de cartouche'));

		//$this->form_validation->set_message('required', 'Ce champ ne peut pas être vide');


		//$this->layout->view('pages/send_order_cartridge', $data);
		if($this->form_validation->run()) {
			//run link action form
			$this->db->set('id_agent_request',$this->input->post('id_agent_request'));
			$this->db->set('id_agent',$this->input->post('id_agent'));
			$this->db->set('id_stock',$this->input->post('id_stock'));
			//$this->db->set('date_order',$this->input->post('date_order'));
			$this->db->set('date_created',date('Y-m-d H:i:s'));
			$this->db->set('date_updated',date('Y-m-d H:i:s'));
			$this->db->set('comment',$this->input->post('comment'));

			//cartridges color
			if($this->input->post('color[0]')==1)
			{
				$this->db->set('color_cyan',1);
			}
			if($this->input->post('color[1]')==2)
			{
				$this->db->set('color_magenta',1);
			}
			if($this->input->post('color[2]')==3)
			{
				$this->db->set('color_yellow',1);
			}
			if($this->input->post('color[3]')==4)
			{
				$this->db->set('color_black',1);
			}

			$this->db->insert('gestion_order_cartridge');


			$this->session->set_flashdata('message',dico('infos_bien_enregistrees',$_SESSION['langue']));
			$_SESSION['flash_message'] = $this->session->flashdata('message');
			redirect(site_url("pages/send_order_cartridge?langue=".$_SESSION['langue']));
		}
		else //If form not activated
		{
			$this->layout->view('pages/send_order_cartridge', $data);

		}

	}

	public function outil_admin($id = null)
	{

		$data['list_agents']=$this->db->select('DISTINCT (cpas_contrats.id_agent),nom,prenom')
				->from('cpas_agents')
				->join('cpas_contrats','cpas_contrats.id_agent=cpas_agents.id_agent','left')
				->where('cpas_contrats.actif=1')
				->order_by('nom', 'asc')
				->get()
				->result();


		if(!empty($id))
		{
			$id_agent=$id;
		}
		else
		{
			if(!empty($this->input->post('inputagent')))
			{
				$id_agent=$this->input->post('inputagent');
			}
		}
		//print_r($id_agent);
		if(!empty($id_agent))
		{
			$data['id_agent']=$id_agent;
			$data['applis']=$this->db->select('*')
					->from('intranet_v2_sous_menu')
					->where('id_menu IN (2,4)')
					->order_by('order_list', 'asc')
					->get()
					->result();


			$data['applis_par_agent']=$this->db->select('*')
					->from('cpas_agents_applis')
					->where('id_agent='.$id_agent)
					->get()
					->result();

			//read data agent selected
			$data['agent']=$this->db->select('*')
					->from('cpas_agents')
					->where('cpas_agents.id_agent='.$id_agent)
					->get()
					->result();

			//Infos contract
			$data['contrats']=$this->db->select('id_contrat,id_agent,
							   tel_1,tel_2,horaire_appel_tel1,horaire_appel_tel2,
							   cpas_contrats.modif_date as modif_date,cpas_contrats.modif_user as modif_user,
							   cpas_hors_departements.label_'.$_SESSION['langue'].' as label_hors_dep,
							   cpas_departements.label_'.$_SESSION['langue'].' as label_dep,
							   cpas_services.label_'.$_SESSION['langue'].' as label_ser,
							   cpas_cellules.label_'.$_SESSION['langue'].' as label_cel,
							   cpas_fonctions.label_'.$_SESSION['langue'].' as label_fonc')
					->from('cpas_contrats')
					->join('cpas_hors_departements','cpas_contrats.id_hors_dep=cpas_hors_departements.id_hors_dep','left')
					->join('cpas_departements','cpas_contrats.id_dep=cpas_departements.id_dep','left')
					->join('cpas_services','cpas_contrats.id_ser=cpas_services.id_ser','left')
					->join('cpas_cellules','cpas_contrats.id_cel=cpas_cellules.id_cel','left')
					->join('cpas_fonctions','cpas_contrats.id_fonc=cpas_fonctions.id_fonc','left')
					->where('id_agent='.$id_agent.' AND cpas_contrats.actif=1 AND cpas_contrats.id_ser<>'.PERS_CONF)
					->get()
					->result();

		}


		$this->layout->view('pages/outil_admin',$data);
	}

	public function photos_annuaire()
	{
		$data['list_agents']=$this->db->select('DISTINCT (cpas_contrats.id_agent),nom,prenom')
				->from('cpas_agents')
				->join('cpas_contrats','cpas_contrats.id_agent=cpas_agents.id_agent','left')
				->where('cpas_contrats.actif=1')
				->order_by('nom', 'asc')
				->get()
				->result();

		$this->layout->view('pages/photos_annuaire',$data);
	}

}