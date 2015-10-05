<?php 

include '../php/conexao.php';
conexaoInfoweb();
 $idArquivo = $_GET['idArquivo'];
 
/* $qry = "SELECT tipoArquivo, arquivo FROM arquivo WHERE idArquivo = ".$idArquivo;
 $res = mysql_query($qry);
 $tipo = mysql_result($res, 0, "tipoArquivo");
 $conteudo = mysql_result($res, 0, "arquivo");

 header("Content-type: $tipo");
 echo $conteudo;*/
 
 
/*header("Content-disposition: attachment; filename=huge_document.pdf");
header("Content-type: application/pdf");*/
$query = "SELECT a.nomeArquivo, a.tipoArquivo, t.nomeAtividade FROM arquivo a INNER JOIN atividade t WHERE a.idArquivo = ".$idArquivo." AND a.atividade_idatividade = t.idAtividade";
$valores = mysql_query($query);
while ($valor = mysql_fetch_object($valores)) {
    $nomeArquivo = $valor->nomeArquivo;
    $tipoArquivo = $valor->tipoArquivo;
    $nomePasta = $valor->nomeAtividade;
}

$path = "../uploads/".$nomePasta."/".$nomeArquivo;
echo $path;

if(file_exists($path) && is_file($path)){
	header('Content-type: '.$tipoArquivo);
	header('Content-disposition: attachment; filename="'.$nomeArquivo.'"');
        header('Content-length: '.  filesize($path));
	readfile($path);
}else{
	echo "<h4>O arquivo n&atilde;o pode ser encontrado no reposit&oacute;rio</h4>";
	}
?>