<?php
include "conexao.php";
$link = conexaoInfoweb();

$nomeUsuario = '';
$subject = "INFOWEBGERENCIAMENTO - Notificação";
$to="";
$message = "";
$from = "";
$headers = "From: naoresponda@olinda.pe.gov.br";

$consulta = "SELECT idUsuario, nomeUsuario FROM usuario WHERE DATEDIFF(ultimoAcesso, CURDATE()) < 7";
$usuarios = mysql_query($consulta, $link) or die(mysql_error());

while($usuario = mysql_fetch_object($usuarios)){
    //seleciona as atividades que estão atrasadas de um usuário específico
    $query = "SELECT a.nomeAtividade, a.dataInicial, a.dataFinal, us.email FROM atividade a INNER JOIN usuario us WHERE DATEDIFF(a.dataFinal, CURDATE()) < 7 AND a.status = 3 AND us.idUsuario = ".$usuario->idUsuario;

    $resultado = mysql_query($query) or die(mysql_error());
    
    $message = "Olá, ".$usuario->nomeUsuario.".\n
    \tEsta mensagem está sendo enviada para notificá-lo(a) que no sistema infowebgerenciamento constam como atrasadas a(s) seguinte(s) atividade(s):";
    $message = $message."\nNome\t\t| Data Inicial\t\t| Data Final";

    while($res = mysql_fetch_object($resultado)){
        $to = $res->email;
        $nomeAtividade = $res->nomeAtividade;
        $dataInicial = $res->dataInicial;
        $dataFinal = $res->dataFinal;
        $message = $message."\n".$nomeAtividade."| ".$dataInicial."| ".$dataFinal."";
    }

    $message = $message."\n\nEsta(s) atividade(s) aguarda(m) solução. Favor marcar uma solução ou alterar sua(s) data(s) final(is)</br>
    \nAtenciosamente:
    \nInfowebgerenciamento - Sistema de gerenciamento de atividades
    \nCoordenadoria de informática - PMO";

    mysql_close($link);
    
    //nescessário colocar um e-mail real
    mail($to,$subject,$message,$headers);
    echo $to."<br>";
    echo $headers;
    
    $myfile = fopen("log_de_emails.txt", "w") or die("Unable to open file!");
    $message = "\n----------------------------------------------".  date("d-m-Y")."\n".$message."\n\n";
    echo $message;
    fwrite($myfile, $message);
    fclose($myfile);
}
?>