<?php
class Organigramme extends CI_Controller
{
	private $theme = 'default';
	
	
	public function __construct()
	{
		parent::__construct();
		
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('MY_url_helper');
		$this->load->helper('assets_helper');
		$this->load->library('layout');
		//CSS
		$this->layout->ajouter_css('bootstrap.min');
		$this->layout->ajouter_css('organigramme');
		//JS
		$this->layout->ajouter_js('jquery');
		$this->layout->ajouter_js('bootstrap.min');
		$this->layout->set_theme('organigramme');
	}
	
	
	function index()
	{
		
		$data['hors_dep'] = $this->db->select('*')
						->from('cpas_hors_departements')
						->where(array('actif'=>1))
						->order_by('indice_ordre', 'asc')
						->get()
						->result();
						
		$data['dep'] = $this->db->select('*')
						->from('cpas_departements')
						->where('actif=1 AND id_dep<>5')
						->order_by('indice_ordre', 'asc')
						->get()
						->result();	

		$data['ser'] = $this->db->select('*')
						->from('cpas_services')
						->where(array('actif'=>1))
						->get()
						->result();	
						
		$data['cel'] = $this->db->select('*')
						->from('cpas_cellules')
						->where(array('actif'=>1))
						->get()
						->result();	
		
		
		// Agents qui sont uniquement à la tête d'un hors département (case orange de l'organigramme)
		$data['agents_hors_dep'] = $this->db->select('cpas_agents.id_agent as id_agent,
							   id_contrat,nom,prenom,
							   cpas_contrats.id_hors_dep,
							   cpas_contrats.flag_resp_dep,
							   cpas_contrats.flag_resp_ser')
						->from('cpas_agents')
						->join('cpas_contrats','cpas_agents.id_agent=cpas_contrats.id_agent')
						->where('cpas_contrats.actif=1 AND cpas_contrats.id_hors_dep<>0 AND cpas_contrats.id_dep=0')
						->order_by('nom','asc')
						->order_by('prenom','asc')
						->get()
						->result();	
		
		
		
		// Agents qui sont uniquement à la tête d'un département (case verte de l'organigramme)
		
		$data['agents_dep'] = $this->db->select('cpas_agents.id_agent as id_agent,
							   id_contrat,nom,prenom,
							   cpas_contrats.id_dep,
							   cpas_contrats.flag_resp_dep,
							   cpas_contrats.flag_resp_ser')
						->from('cpas_agents')
						->join('cpas_contrats','cpas_agents.id_agent=cpas_contrats.id_agent')
						->where('cpas_contrats.actif=1 
									AND cpas_contrats.id_hors_dep=0 
									AND cpas_contrats.id_ser=0 
									AND cpas_contrats.id_cel=0 
									AND cpas_contrats.id_dep<>0')
						->order_by('nom','asc')
						->order_by('prenom','asc')
						->get()
						->result();	
		
		
		// Agents qui sont uniquement à la tête d'un service (case jaune de l'organigramme)	
		
		$data['agents_ser'] = $this->db->select('cpas_agents.id_agent as id_agent,
							   id_contrat,nom,prenom,
							   cpas_contrats.id_dep,
							   cpas_contrats.id_ser,
							   cpas_contrats.flag_resp_dep,
							   cpas_contrats.flag_resp_ser')
						->from('cpas_agents')
						->join('cpas_contrats','cpas_agents.id_agent=cpas_contrats.id_agent')
						->where('cpas_contrats.actif=1 
									AND cpas_contrats.id_hors_dep=0 
									AND cpas_contrats.id_ser<>0 
									AND cpas_contrats.id_cel=0 
									AND cpas_contrats.id_dep<>0')
						->order_by('nom','asc')
						->order_by('prenom','asc')
						->get()
						->result();	
						
		
		
		// Agents qui sont uniquement à la tête d'une cellule (petite case jaune claire de l'organigramme)
		$data['agents_cel'] = $this->db->select('cpas_agents.id_agent as id_agent, 
							   id_contrat,nom,prenom,
							   cpas_contrats.id_dep,
							   cpas_contrats.id_ser,
							   cpas_contrats.id_cel,
							   cpas_contrats.flag_resp_dep,
							   cpas_contrats.flag_resp_ser')
						->from('cpas_agents')
						->join('cpas_contrats','cpas_agents.id_agent=cpas_contrats.id_agent')
						->where('cpas_contrats.actif=1 
									AND cpas_contrats.id_hors_dep=0 
									AND cpas_contrats.id_ser<>0 
									AND cpas_contrats.id_cel<>0 
									AND cpas_contrats.id_dep<>0')
						->order_by('nom','asc')
						->order_by('prenom','asc')
						->get()
						->result();	
						
		$this->layout->view('organigramme/index',$data);
	}
}