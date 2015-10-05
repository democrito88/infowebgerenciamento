<?php 

include 'php/conexao.php';
 if(isset($_GET['idArquivo'])){  $idArquivo = $_GET['idArquivo'];}
 if(isset($_POST['idArquivo'])){  $idArquivo = $_GET['idArquivo'];}
 //else{  $idArquivo = "5";}
 
 $qry = "SELECT nomeArquivo, tipoArquivo, arquivo FROM arquivo WHERE idArquivo = ".$idArquivo;
 $res = mysql_query($qry);
 if($qry != false){
	 $nome = mysql_result($res, 0, "nomeArquivo");
	 $conteudo = mysql_result($res, 0, "arquivo");
 }else{
	 echo "Busca faiô!";
	 }
 header('Content-Disposition: attachment; filename="'.$nome.'"');
 echo $conteudo;

?>