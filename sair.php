<?php 
//include "php/email.php?nomeUsuario=".$_GET['nomeUsuario'];
session_start();
session_destroy();
echo "<script>window.location ='testelogin.php'</script>";
?>