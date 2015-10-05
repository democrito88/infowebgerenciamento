<?php
include 'php/conexao.php';

conexaoInfoweb();
$idAtividade = $_GET['idAtividade'];
$nomeAtividade = $_GET['nomeAtividade'];
$idUsuario = $_GET['idUsuario'];
$contador = 0;
//inserindo os arquivos associados
foreach($_FILES['arquivo']['tmp_name'] as $arquivo){
    $tamanho = $_FILES['arquivo']['size'][$contador];
    $tipo    = $_FILES['arquivo']['type'][$contador];
    $nome  = $_FILES['arquivo']['name'][$contador];

    if($tamanho != "0"){
        if ( $arquivo != "none" ){
            $fp = fopen($arquivo, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);
        }
        mysql_query("INSERT INTO arquivo(`nomeArquivo`,`tipoArquivo`,`dataUpload`,`dataAlteracao`,`atividade_idAtividade`) VALUES ('".$nome."','".$tipo."',DATE('".date('Y-m-d')."'),DATE('0000-00-00'),'".$idAtividade."')") or die(mysql_error());

        //criando um diretório para o arquivo, se ele ainda não existir e se houver arquivo a ser adicionado
        if($_FILES['arquivo']['tmp_name'] != NULL){
            $path = "uploads/".$nomeAtividade."/";
            if(!is_dir($path)){
                mkdir($path,0777);
                echo "<h4>Passou aqui.</h4></br>";
            }
            $teste = move_uploaded_file($_FILES['arquivo']['tmp_name'][$contador], $path."/".$nome);
        }
        $contador += 1;
    }

}//fim foreach

header( 'Location: /infowebgerenciamento/editarArquivos.php?idAtividade='.$idAtividade.'&idUsuario='.$idUsuario ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/editarArquivos.php?idAtividade='.$idAtividade.'&idusuario='.$idUsuario ) ;
?>