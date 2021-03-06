<?php

class User extends CI_Controller
{
	private $theme = 'default';
	private $var = null;
	private $var1 = null;
	private $var2 = null;
	
	public function __construct()
	{
		parent::__construct();
		
		//	Chargement des ressources pour tout le contrôleur
		$this->load->database();
		$this->load->helper('MY_url_helper');
		$this->load->helper('assets_helper');
		$this->load->library('layout');
		//$this->layout->ajouter_css('databases.min');
		$this->layout->ajouter_css('bootstrap.min');
		$this->layout->ajouter_css('sb-admin');
		
		$this->layout->set_theme('login');
		//$this->load->helper('language');
	}
	
	
	public function login()
	{
		
		$this->load->library('form_validation');
	
		// That method creates delimiters by default for messages errors (<p></p>).
		$this->form_validation->set_error_delimiters('<p class="alert alert-danger has-error">', '</p>');
		
		//	Form validation rules
		
		$this->form_validation->set_rules('login',  '"Login"',  'required');
		$this->form_validation->set_rules('password', '"Password"', 'required');
		
		$this->form_validation->set_message('required', 'Ce champ ne peut pas être vide');
		
		//Compare infos with LDAP			
		include(APPPATH.'/libraries/config_ldap/config_ldap.php');
		
		//Form validation			
		if($this->form_validation->run())
		{
			
			$ldap = ldap_connect($ldap_host);
			$username = $this->input->post('login');
			$password = $this->input->post('password');

			$ldaprdn = $username.$ldap_domain;

			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

			$bind = @ldap_bind($ldap, $ldaprdn, $password);

			//Verify if the user and password are correct in LDAP
			if ($bind) {
				$filter="(sAMAccountName=$username)";
				$result = ldap_search($ldap,$ldap_dc_connect,$filter);
				ldap_sort($ldap,$result,"sn");
				$info = ldap_get_entries($ldap, $result);
				for ($i=0; $i<$info["count"]; $i++)
				{
					if($info['count'] > 1)
						break;
					
					//read infos about current user
					$user=$this->db->select('*')
					->from('cpas_agents')
					->where(array('login_nt'=>$this->input->post('login')))
					->get()
					->result();
					session_set_cookie_params(0);
					$this->load->library('session');
				
					$this->session->set_userdata('User', $user[0]);

					// read contracts
					$contrats=$this->db->select('*')
							->from('cpas_contrats')
							->where('id_agent='.$_SESSION['User']->id_agent.' AND cpas_contrats.actif=1 AND cpas_contrats.id_ser<>'.PERS_CONF)
							->get()
							->result();
					$this->session->set_userdata('Contrats', $contrats);

					//read autorized apps for the current agent

//					$this->load->helper('cookie');
					$applis_agent=$this->db->select('*')
							->from('cpas_agents_applis')
							->where('id_agent='.$_SESSION['User']->id_agent)
							->get()
							->result();
					$this->session->set_userdata('Apps', $applis_agent);
					//$_COOKIE['Apps']=$_SESSION['Apps'];
//					var_dump($_SESSION['Apps']);
//					exit;
//					$this->input->set_cookie('Apps',$applis_agent);
					//$this->input->cookie('Apps');
					redirect(site_url("pages/index"));
					
				}
				@ldap_close($ldap);
			} else {
				$this->session->set_flashdata( 'no_connect','Votre login ou mot de passe est incorrect / Uw login of wachtwoord is onjuist ');
				$data['flash_message'] = $this->session->flashdata('no_connect');
				$this->layout->view('user/login',$data);
			}
		}
		else //If form not activated
		{
			$this->layout->view('user/login');
		
		}
		
		//read infos about current user
		/* $user=$this->db->select('*')
		->from('cpas_agents')
		->where(array('login_nt'=>$this->input->post('login')))
		//->where(array('login_nt'=>$this->input->post('login'),'password_email'=>sha1($this->input->post('password'))))
		->get()
		->result();


		//Form validation
		if($this->form_validation->run())
		{

			//print_r($user);

			if(!empty($user))
			{
				//session_start();
				$this->load->library('session');
				//$this->session->set_userdata($user);
				$this->session->set_userdata('User', $user[0]);

				// read contracts
				$contrats=$this->db->select('*')
						->from('cpas_contrats')
						->where('id_agent='.$_SESSION['User']->id_agent.' AND cpas_contrats.actif=1 AND cpas_contrats.id_ser<>115')
						->get()
						->result();
				$this->session->set_userdata('Contrats', $contrats);
				redirect(site_url("pages/index"));
			}
			else
			{
				 $this->session->set_flashdata('noconnect', 'Aucun compte ne correspond à vos identifiants ');
				redirect(site_url("user/login"));
			}

		}
		else
		{

			$this->layout->view('user/login');

		}*/
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url("user/login"));
	}
	
	
	
}