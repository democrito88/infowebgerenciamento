<?PHP
include 'php/funcoes.php';

conexaoInfoweb();
$id = $_GET['idProcesso'];
$nomeProcesso = $_POST['nomeProcesso'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];
$responsavel = $_POST['responsavel'];

//Reverte a data para o formato do banco
$dataInicial = date_format(date_create($dataInicial), "Y-m-d");
$dataFinal = date_format(date_create($dataFinal), "Y-m-d");

$sub = mysql_query("UPDATE processo SET nomeProcesso='".$nomeProcesso."', dataInicial=DATE('".$dataInicial."'), dataFinal=DATE('".$dataFinal."'), status='".$status."', descricao = '".$descricao."', usuario_idUsuario='".$responsavel."' WHERE idProcesso = ".$id);

header( 'Location: /infowebgerenciamento/processo.php' ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/processo.php' ) ;
?>