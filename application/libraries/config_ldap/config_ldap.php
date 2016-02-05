<?php
//ini_set("memory_limit","8M");
 // variable paramètres

 $ldap_host = "10.102.97.94";
 $ldap_login ="webadmin";
 $ldap_pass= "webadmin5123";
 //$ldap_login ="administrator";
 //$ldap_pass= "cpasxl416352.";
 $ldap_dc_connect="DC=cpasixelles,DC=be";
 $ldap_domain = "@cpasixelles.be";
 
 
/*	
    $ldap = ldap_connect($ldap_host);
    $username = 'vrebos.sylvie';
    $password = '---';

    $ldaprdn = $username.$ldap_domain;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);


    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,$ldap_dc_connect,$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
            echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
            echo '<pre>';
            var_dump($info);
            echo '</pre>';
            $userDn = $info[$i]["distinguishedname"][0]; 
        }
        @ldap_close($ldap);
    } else {
        $msg = "Invalid email address / password";
        echo $msg;
    }
*/
 //$ad=ldap_connect($ldap_host);
 //echo 'Le résultat de connexion est ' . $ad . '<br />';

 
?>