<?php
conexaoInfoweb();

$nome = $_POST['nome'];

$senha = $_POST['senha'];
$login = $_POST['login'];
$email = $_POST['email'];

$query = "INSERT INTO usuario (nomeUsuario, login, senha, email) VALUES ('".$nome."','".$login."','".sha1($senha)."','".$email."')";
if(!mysql_query($query)){
    //chamar página de erro
    echo "<h3>Falhou.</h3>";
}else{
    header( 'Location: /infowebgerenciamento/telalogin.php' ) ;
    //header( 'Location: http://sefad.pmo.local/infowebgerenciamento/telalogin.php' ) ;
}
?>