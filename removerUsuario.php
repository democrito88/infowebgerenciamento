<?PHP
include 'php/conexao.php';
include 'php/funcoes.php';
conexaoInfoweb();

$id = $_GET['idUsuario'];
//remove o usuario
$sub = mysql_query("DELETE FROM usuario WHERE idUsuario = ".$id);

header( 'Location: /infowebgerenciamento/index.php' ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/index.php' ) ;

?>