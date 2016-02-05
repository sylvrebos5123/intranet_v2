<?php

class Calendrier extends CI_Controller
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
		//$this->layout->ajouter_css('datatables.min');
		$this->layout->ajouter_css('bootstrap.min');
		$this->layout->ajouter_css('sb-admin');
		//JS
		$this->layout->ajouter_js('jquery');
		$this->layout->ajouter_js('bootstrap.min');
		//$this->layout->ajouter_js('my_functions');
		$this->layout->set_theme('calendrier');
		
	}
	
	function agenda_officiel()
	{
		$rootpath = APPPATH.'\\libraries';
		include($rootpath.'\\exchange\\ews.php');
		include($rootpath.'\\config_ews\\config_ews.php');

		//agenda officiel
		$username=trim($email_array['agenda_off']['email']);
		$password=trim($email_array['agenda_off']['email_psw']);
		$start_date='01-01-'.date('Y');
		$end_date='31-12-'.date('Y');
		$data['a_rdv'] = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
		$this->layout->view('calendrier/agenda_officiel',$data);
		
	}
	
	function mon_agenda()
	{
		$rootpath = APPPATH.'\\libraries';
		include($rootpath.'\\exchange\\ews.php');
		include($rootpath.'\\config_ews\\config_ews.php');

		//agenda officiel
		$username=trim($_SESSION['User']->email);
		$password=trim(base64_decode($_SESSION['User']->password_email));
		$start_date='01-01-'.date('Y');
		$end_date='31-12-'.date('Y');
		$data['a_rdv'] = GetEwsCalFromToListItems($username,$password,$start_date,$end_date,''); 
		$this->layout->view('calendrier/mon_agenda',$data);
		
	}
	
}