<?php 

include 'php/conexao.php';

 $arquivo = $_FILES['arquivo']['tmp_name']; 
 $tamanho = $_FILES['arquivo']['size'];
 $tipo    = $_FILES['arquivo']['type'];
 $nome  = $_FILES['arquivo']['name'];
 $titulo  = $_POST['titulo'];

 if ( $arquivo != "none" )
 {
 $fp = fopen($arquivo, "rb");
 $conteudo = fread($fp, $tamanho);
 $conteudo = addslashes($conteudo);
 fclose($fp); 

 $qry = "INSERT INTO arquivos VALUES (0,'".$nome."','".$titulo."','".$conteudo."','".$tipo."')";

 mysql_query($qry);

 if(mysql_affected_rows($conn) > 0)
 echo "O arquivo foi gravado na base de dados.";
 else
 echo "Não foi possível gravar o arquivo na base de dados.";
 }
 else
 echo "Não foi possível carregar o arquivo para o servidor.";
 
 ?>