<?php

class Order_cartridge extends CI_Controller
{
	private $theme = 'default';
	private $var = null;
	private $var1 = null;
	private $var2 = null;
	
	public function __construct()
	{
		parent::__construct();
		
		//	Chargement des ressources pour tout le contr�leur
		$this->load->database();
		$this->load->helper('MY_url_helper');
		$this->load->helper('assets_helper');
		$this->load->library('layout');
		$this->layout->ajouter_css('bootstrap.min');
		$this->layout->ajouter_css('sb-admin');
		$this->layout->ajouter_js('my_functions');
		//$this->layout->set_theme('calendrier');
		//$this->load->helper('language');
	}
	
	
	public function send_order()
	{
		
		$this->load->library('form_validation');
	
		// That method creates delimiters by default for messages errors (<p></p>).
		$this->form_validation->set_error_delimiters('<p class="alert alert-danger has-error">', '</p>');
		
		//	Form validation rules
		
		$this->form_validation->set_rules('login',  '"Login"',  'required');
		$this->form_validation->set_rules('password', '"Password"', 'required');
		
		$this->form_validation->set_message('required', 'Ce champ ne peut pas être vide');

		$this->layout->view('order_cartridge/send_order');

	}
	
	
	
	
	
}