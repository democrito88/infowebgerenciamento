<?php
include 'php/funcoes.php';

conexaoInfoweb();
//preciso pegar o id de quem está logado (fazendo a modificação) e do responsável pelo id do processo
$idProcesso = $_GET['idProcesso'];
$idAtividade = $_GET['idAtividade'];
$idUsuario = $_GET['idUsuario'];
$login = $_GET['login'];
$flag = $_GET['flag'];//em caso de o usuário vir de 'minhasAtividades.php'
$atividade = mysql_query("SELECT a.idAtividade, a.nomeAtividade, a.dataInicial, a.dataFinal, a.status, a.usuario_idUsuario, a.situacao, p.usuario_idUsuario AS usuarioProcesso FROM atividade a INNER JOIN processo p WHERE idAtividade = '".$idAtividade."' AND a.processo_idProcesso = p.idProcesso");
if($atividade)
    while ($linha = mysql_fetch_object($atividade)){
        //inserindo o log da atividade
        $idAtividade = $linha->idAtividade;
        $nomeAtividade = $linha->nomeAtividade;
        $dataInicial = $linha->dataInicial;
        $dataFinal = $linha->dataFinal;
        $status = $linha->status;
        $responsavel = $linha->usuario_idUsuario;
        $situacao = $linha->situacao;
        $usuarioProcesso = $linha->usuarioProcesso;

        //Reverte a data para o formato do banco
        $dataInicial = $dataInicial == "0000-00-00" ? "0000-00-00" : date_format(date_create($dataInicial), "Y-m-d");
        $dataFinal = $dataFinal == "0000-00-00" ? "0000-00-00" : date_format(date_create($dataFinal), "Y-m-d") ;

        //a identidade de quem modificou
        $consultaNomeUsuario = mysql_query("SELECT idUsuario FROM usuario WHERE login = '".$login."'");

        while($res = mysql_fetch_object($consultaNomeUsuario)){
            $modificador = $res->idUsuario;
        }

        $subP = mysql_query("INSERT INTO logatividade (nomeLogAtividade,dataInicial,dataFinal,status,situacao,atividade_idAtividade,atividade_usuario_idUsuario,processo_idProcesso,processo_usuario_idUsuario,usuario_idUsuario,dataAlteracao,modificador) VALUES ('".$nomeAtividade."',DATE('".$dataInicial."'),DATE('".$dataFinal."'),'".$status."','".$situacao."','".$idAtividade."','".$responsavel."','".$idProcesso."','".$usuarioProcesso."',".$idUsuario.",NOW(),'".$modificador."') ") or die(mysql_error());
}
else{echo "<h4>Fai&ocirc;: log da ação</h4></br>";}

/*$consulta = mysql_query("SELECT idAtividade FROM atividade ORDER BY idAtividade DESC LIMIT 1");
        if(!$consulta)
        while($atividade = mysql_fetch_object($consulta)){
        $idAtividade = $atividade->idAtividade;
}
        else{echo "<h4>Fai&ocirc;: busca de tarefa</h4></br>";} */

$contador = 0;
//inserindo o arquivo associado
if($_FILES != NULL){
    foreach($_FILES['arquivo']['tmp_name'] as $arquivo){
        $tamanho = $_FILES['arquivo']['size'][$contador];
        $tipo    = $_FILES['arquivo']['type'][$contador];
        $nome  = $_FILES['arquivo']['name'][$contador];

        if ( $arquivo != "none" ){
            $fp = fopen($arquivo, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);
        }

        echo "(`nomeArquivo`,`tipoArquivo`,`dataUpload`,`dataAlteracao`,`atividade_idAtividade`) VALUES ('".$nome."','".$tipo."','".date('Y-m-d'
    )."','DATE('0000-00-00')','".$idAtividade."')"; 
        mysql_query("INSERT INTO arquivo(`nomeArquivo`,`tipoArquivo`,`dataUpload`,`dataAlteracao`,`atividade_idAtividade`) VALUES ('".$nome."','".$tipo."','".date('Y-m-d'
    )."','DATE('0000-00-00')','".$idAtividade."')") or die(mysql_error());

        //criando um diretório para o arquivo, se ele ainda não existir e se houver arquivo a ser adicionado
        if($_FILES['arquivo']['tmp_name'] != NULL){
            $path = "uploads/".$nomeAtividade."/";
            if(!is_dir($path)){
                mkdir($path,0777);
            }
            $teste = move_uploaded_file($_FILES['arquivo']['tmp_name'], $path);
        }

        $contador += 1;
    }

}

$nomeAtividade = $_POST['nomeAtividade'];
$situacao = $_POST['situacao'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$status = $_POST['status'];
$responsavel = $_POST['responsavel'];
$novoProcessoPai = $_POST['processoPai'];

//Reverte a data para o formato do banco
$dataInicial = date_format(date_create($dataInicial), "Y-m-d");
$dataFinal = date_format(date_create($dataFinal), "Y-m-d");

echo "nomeAtividade='".$nomeAtividade."', situacao='".$situacao."', dataInicial=DATE('".$dataInicial."'), dataFinal=DATE('".$dataFinal."'),status='".$status."', processo_idProcesso = '".$novoProcessoPai."', usuario_idUsuario='".$responsavel."'";
$sub = mysql_query("UPDATE atividade SET nomeAtividade='".$nomeAtividade."', situacao='".$situacao."', dataInicial=DATE('".$dataInicial."'), dataFinal=DATE('".$dataFinal."'),status='".$status."', processo_idProcesso = '".$novoProcessoPai."', usuario_idUsuario='".$responsavel."' WHERE idAtividade = ".$idAtividade);
if($sub){
    echo "<h4>Tarefa atualizada</h4></br>";
}else{
    echo "<h4>Fai&ocirc;: atualização de tarefa</h4></br>";
}
header( isset($_GET['flag']) && $flag == "true"? 'Location: /infowebgerenciamento/minhasAtividades.php?idUsuario='.$idUsuario : 'Location: /infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;
        //header( isset($_GET['flag']) && $flag == "true"? 'Location: http://sefad.pmo.local/infowebgerenciamento/minhasAtividades.php?idUsuario='.$idUsuario : 'Location: http://sefad.pmo.local/infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;	
?>