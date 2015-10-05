<?PHP
include 'php/funcoes.php';

$id = $_GET['idProcesso'];
conexaoInfoweb();

//remover as atividades do processo
$query = "DELETE FROM atividade WHERE processo_idProcesso = ".$id;
$teste = mysql_query($query);
$query = "DELETE FROM processo WHERE idProcesso = ".$id;
$teste1 = mysql_query($query);

if($teste != false){
    echo "<h3>aê11".$id."</h3> </br>";
    }
if($teste1 != false){
    echo "<h3>aê222</h3>";
    }

/*remove ações nos subprocessos do processo
$consulta1 = mysql_query("SELECT idSubProjeto FROM subprocesso WHERE Projeto_idProcesso=".$id);
while($subprocessos = mysql_fetch_object($consulta1)){
    $idSubProjeto = $subprocessos->idSubProjeto;

    //seleciona as ações relacionadas ao sub processo
    $sub4 = mysql_query("SELECT idAcao FROM acao WHERE subProjeto_idSubProjeto = ".$idSubProjeto);

    //seleciona os arquivos relacionados às ações
    while($acao = mysql_fetch_object($sub4)){
        $sub3 = mysql_query("DELETE FROM arquivo WHERE acao_idAcao = ".$acao->idAcao);
        }

    $consulta2 = mysql_query("DELETE FROM acao WHERE subProjeto_idSubProjeto = ".$idSubProjeto);
    }

//remove os subprocessos no processo
$consulta3 = mysql_query("DELETE FROM subprocesso WHERE processo_idProcesso = ".$id);

//remove o processo
$sub = mysql_query("DELETE FROM processo WHERE idProcesso = ".$id);*/

    
    
header( 'Location: /infowebgerenciamento/processo.php' ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/processo.php' ) ;
?>