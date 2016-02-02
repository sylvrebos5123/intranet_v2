<?php


function dico($label,$code_langue)
{
	include(APPPATH. '/tools/array_dico.php');
	//$query=$this->db->query('SELECT * FROM cpas_dico where keyword="'.$label.'"');
	
	if(!isset($array_dico[$label][$code_langue]))
	{
		return 'to_translate['.$label.']['.$code_langue.']';
	}
	else
	{
		return $array_dico[$label][$code_langue];
	}
}