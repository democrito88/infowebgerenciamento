<?php
//include "conexao.php";
conexaoInfoweb();
$nomeUsuario = '';
$subject = "INFOWEBGERENCIAMENTO - Notificação";
$to="";
$message = "";
$from = "";
$headers = "From: naoresponda@olinda.pe.gov.br";


//seleciona as atividades que estão atrasadas e o usuário específico
$query = "SELECT ac.nomeAcao, ac.dataInicial, ac.dataFinal, us.nomeUsuario, us.email FROM acao ac INNER JOIN usuario us WHERE DATEDIFF(ac.dataFinal, CURDATE()) < 20 AND ac.status = 3";

$resultado = mysql_query($query);

if(mysql_num_rows($resultado) > 0){

    $message = "Olá, ".$nomeUsuario.".\n
    \tEsta mensagem está sendo enviada para notificá-lo(a) que no sistema infowebgerenciamento constam como atrasadas a(s) seguinte(s) atividade(s):";
    $message = $message."\nNome\t\t| Data Inicial\t\t| Data Final";

    while($res = mysql_fetch_object($resultado)){
        $to = $res->email;
        $nome = $res->nomeUsuario;
        $nomeAcao = $res->nomeAcao;
        $dataInicial = $res->dataInicial;
        $dataFinal = $res->dataFinal;
        $message = $message."\n".$nomeAcao."| ".$dataInicial."| ".$dataFinal."";
    }

    $message = $message."\n\nEsta(s) atividade(s) aguarda(m) solução. Favor marcar uma solução ou alterar sua(s) data(s) final(is)</br>
    \nAtenciosamente:
    \nInfowebgerenciamento - Sistema de gerenciamento de atividades
    \nCoordenadoria de informática - PMO";

    //nescessário colocar um e-mail real
    mail($to,$subject,$message,$headers);
    echo $to."<br>";
    echo $headers;
    }	
	
?>