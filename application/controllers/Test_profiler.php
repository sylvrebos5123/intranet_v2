<?php

class Test_profiler extends CI_Controller
{

	public function index()
	{
		//$this->output->enable_profiler(true);
		//	Première requête
		$this->benchmark->mark('requete1_start');
		$query = $this->db->query('SELECT `id_agent`, `nom`, `prenom` FROM `cpas_agents`')->result();
		$this->benchmark->mark('requete1_end');
		
		//	Deuxième requête
		$this->benchmark->mark('requete2_start');
		$query = $this->db->select('id_agent, nom, prenom')->from('cpas_agents')->get()->result();
		$this->benchmark->mark('requete2_end');
 
		$this->output->enable_profiler(true);
	}






}