<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 

include 'php/conexao.php';

$qry = "SELECT id, nome, titulo, tipo FROM arquivos";
$res = mysql_query($qry);

while($fila = mysql_fetch_array($res))
{
echo "$fila[titulo]<br>
	  $fila[nome] ($fila[tipo])<br>
	  <a href=\"baixar_arquivo.php?id=$fila[id]\">Fazer Download</a><br>";
}
?>

</body>
</html>