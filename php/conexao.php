<?php
function conexaoGLPI(){
    $db_host		= 'localhost';
    $db_user		= 'root';
    $db_pass		= '';
    $db_database	= 'sefad_glpi'; 

    $link = mysql_connect($db_host,$db_user,$db_pass) or die('Não foi possível se conectar ao banco sefad_glpi!');

    mysql_set_charset('UTF8', $link);
    mysql_select_db($db_database,$link);
    
    return $link;
}

function conexaoInfoweb(){
    //este é o arquivo de conexão com o banco de dados

    $db_host		= 'localhost';
    $db_user		= 'root';
    $db_pass		= '';
    $db_database	= 'infowebgerenciamento'; 

    $link = mysql_connect($db_host,$db_user,$db_pass) or die('Não foi possível se conectar ao banco de dados!');

    mysql_set_charset('UTF8', $link);
    mysql_select_db($db_database,$link);
    
    return $link;
}
?>