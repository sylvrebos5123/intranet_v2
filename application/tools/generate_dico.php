<?php

//echo $this->db['default']->item('hostname');
$db=$this->load->database('default', TRUE);
$query=$this->db->query('SELECT * FROM cpas_dico');

//print_r($query->result());

$outStr="<?php \n";
$outStr.="/***********************************************/ \n";
$outStr.="/* fichier généré par dico_generate_array.php  */ \n";
$outStr.="/* sur base des informations contenues dans la */ \n";
$outStr.="/* table `cpas_dico` dans la DB                */ \n";
$outStr.="/* génére le : ".date("Y-m-d h:i:s")."             */ \n";
$outStr.="/***********************************************/ \n";
$outStr.="/* les modifications manuelles effectuées dans */ \n";
$outStr.="/* ce fichier seront écrasés lors de           */ \n";
$outStr.="/* l'utilisation de generate_dico.php     */ \n";
$outStr.="/***********************************************/ \n";
$outStr.="\$array_dico=array();\n";

foreach ($query->result() as $row){
             //echo $row->keyword;
	$outStr.="\$array_dico[\"".$row->keyword."\"][\"F\"]=\"".$row->traduction_F."\";\n";
	$outStr.="\$array_dico[\"".$row->keyword."\"][\"N\"]=\"".$row->traduction_N."\";\n";
}

$nomFichier=APPPATH."/tools/array_dico.php";
$fichierOuvert = @fopen($nomFichier, "w");
fputs($fichierOuvert,($outStr));
			
fclose($fichierOuvert);
//echo "** Fichier sauvegardé et modifié **";
//echo "** fin  : ".date("Y-m-d h:i:s");