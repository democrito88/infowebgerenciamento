<?PHP
include 'php/funcoes.php';

conexaoInfoweb();
$nomeProcesso = $_POST['nomeProcesso'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$situacao = $_POST['situacao'];
$status = $_POST['status'];
$responsavel = $_POST['responsavel'];

if($_GET['idProcessoPai'] != 0){
        $query = "INSERT INTO processo (nomeProcesso,dataInicial,dataFinal,situacao,status,usuario_idUsuario,idProcessoPai) VALUES ('".$nomeProcesso."',DATE('".$dataInicial."'),DATE('".$dataFinal."'),'".$situacao."','".$status."','".$responsavel."','".$_GET['idProcessoPai']."') ";
}else{
        $query = "INSERT INTO processo (nomeProcesso,dataInicial,dataFinal,situacao,status,usuario_idUsuario,idProcessoPai) VALUES ('".$nomeProcesso."',DATE('".$dataInicial."'),DATE('".$dataFinal."'),'".$situacao."','".$status."','".$responsavel."',NULL) ";
}
$sub = mysql_query($query);
if (!$sub) {
        die('Invalid query: ' . mysql_error());
}

if($_GET['idProcessoPai'] != NULL){header( 'Location: /infowebgerenciamento/processo.php?idProcessoPai='.$_GET['idProcessoPai'] ) ;}
else{header( 'Location: /infowebgerenciamento/processo.php' ) ;}
/*if($_GET['idProcessoPai'] != NULL){header( 'Location: http://sefad.pmo.local/infowebgerenciamento/processo.php?idProcessoPai='.$_GET['idProcessoPai'] ) ;}
else{header( 'Location: http://sefad.pmo.local/infowebgerenciamento/processo.php' ) ;}*/

?>