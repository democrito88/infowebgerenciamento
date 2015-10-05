<?PHP
include 'php/funcoes.php';

conexaoInfoweb();
$id = $_GET['idAtividade'];
$flag = isset($_GET['flag']) ? $_GET['flag'] : NULL ;
$idUsuario = isset($_GET['idUsuario'])? $_GET['idUsuario'] : NULL ;

//consulta se há arquivos associados e os remove
$del = mysql_query("DELETE FROM arquivo WHERE atividade_idAtividade = ".$id);

$busca = mysql_query("SELECT nomeAtividade FROM atividade WHERE idAtividade = ".$id);
while($atividade = mysql_fetch_object($busca)){
    $nomeAtividade = $atividade->nomeAtividade;
}

//remove os arquivos do repositório
echo array_map('unlink', glob("uploads/".$nomeAtividade."/*")) ? "verdadeiro1" : "falso1";

//remove o diretório
echo rmdir ( "uploads/".$nomeAtividade ) ? "verdadeiro2" : "falso2";

//consulta o histórico da atividade e o remove
$removeHistorico = mysql_query("DELETE FROM logAtividade WHERE atividade_idAtividade = ".$id)or die(mysql_error());

//consulta o id do subprocesso relacionado para o redirecionamento de página
$consulta = mysql_query("SELECT processo_idProcesso FROM atividade WHERE idAtividade=".$id);
while($resultado = mysql_fetch_object($consulta)){
    $idProcesso = $resultado->processo_idProcesso;
}
//remove a atividade
$sub = mysql_query("DELETE FROM atividade WHERE idAtividade = ".$id) or die(mysql_error());

header( !is_null($flag) && $flag=="true" ? 'Location: /infowebgerenciamento/minhasAtividades.php?idUsuario='.$idUsuario : 'Location: /infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;
/*header( !is_null($flag) && $flag=="true" ? 'Location: http://sefad.pmo.local/infowebgerenciamento/minhasAtividades.php?idUsuario='.$idUsuario : 'Location: http://sefad.pmo.local/infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;*/
?>