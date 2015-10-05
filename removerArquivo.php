<?php
//Para conectar com o banco de dados
$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'infowebgerenciamento'; 

$link = mysql_connect($db_host,$db_user,$db_pass) or die('Não foi possível se conectar ao banco de dados!');

mysql_set_charset('UTF8', $link);
mysql_select_db($db_database,$link);

//começo do código propriamente dito

$id = $_GET['idArquivo'];
$idUsuario = $_GET['idUsuario'];

echo !is_null($id) && isset($id)? "id n&atilde;o &eacute; NULO e seu valor &eacute; ".$id."</br>" : "id &eacute; nulo</br>" ;

$consulta = mysql_query("SELECT at.nomeAtividade, arq.atividade_idAtividade, arq.nomeArquivo FROM arquivo arq INNER JOIN atividade at WHERE arq.idArquivo=".$id." AND at.idAtividade = arq.atividade_idAtividade", $link) or die(mysql_error());

if($consulta == false){echo "consulta retorna falso</br>";}
if(!is_null($consulta)){echo "consulta->".$consulta;}

while($resultado = mysql_fetch_object($consulta)){
    $idAtividade = $resultado->atividade_idAtividade;
    $nomeAtividade = $resultado->nomeAtividade;
    $nomeArquivo = $resultado->nomeArquivo;
}

echo "</br>".$nomeArquivo." - ".$nomeAtividade;
if(isset($nomeArquivo) && isset($nomeAtividade)){echo "</br>todos setados";}
$consultas = mysql_query("DELETE FROM arquivo WHERE idArquivo = ".$id, $link);
unlink("uploads/".$nomeAtividade."/".$nomeArquivo);

mysql_close($link);

header( 'Location: /infowebgerenciamento/editarArquivos.php?idAtividade='.$idAtividade.'&idUsuario='.$idUsuario ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/editarArquivos.php?idAtividade='.$idAtividade.'&idUsuario='.$idUsuario ) ;
?>