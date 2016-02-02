<?php

class Alphabet
{
	private $lettres = 'abcdefghijklmnopqrstuvwxyz';
	
	public function __construct()
	{
		
	}
	
	public function recuperer_alphabet()
	{
		return $this->lettres;
	}
	
	public function supprimer_alphabet()
	{
		$this->lettres = '';
	}
	
	public function changer_alphabet($lettres)
	{
		if(is_string($lettres) AND !empty($lettres))
		{
			$this->lettres = $lettres;
			return true;
		}
		else
		{
			return false;
		}
	}
}