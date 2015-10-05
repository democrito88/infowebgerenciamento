<?PHP
include 'php/funcoes.php';

conexaoInfoweb();
$idProcesso = $_GET['idProcesso'];
$nomeAtividade = $_POST['nomeAtividade'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$status = $_POST['status'];
$responsavel = $_POST['responsavel'];
$situacao = $_POST['situacao'];

$dataInicial = !is_null($dataInicial) ? date_format(date_create($dataInicial), "Y-m-d") : "0000-00-00";
$dataFinal = !is_null($dataFinal) ? date_format(date_create($dataFinal), "Y-m-d") : "0000-00-00";
	
//inserindo a atividade
$sub = mysql_query("INSERT INTO atividade (processo_idProcesso,nomeAtividade,dataInicial,dataFinal,status,usuario_idUsuario,situacao) VALUES ('".$idProcesso."','".$nomeAtividade."',DATE('".$dataInicial."'),DATE('".$dataFinal."'),'".$status."','".$responsavel."','".$situacao."') ");

if(!$sub){
    echo "<h4>Fai&ocirc; 1    ".$dataInicial."</h4></br>";
    echo "INSERT INTO atividade (processo_idProcesso,nomeAtividade,dataInicial,dataFinal,status,usuario_idUsuario,situacao) VALUES ('".$idProcesso."','".$nomeAtividade."',DATE('".$dataInicial."'),DATE('".$dataFinal."'),'".$status."','".$responsavel."','".$situacao."') ";
    die('Invalid query: ' . mysql_error());
}

$consulta = mysql_query("SELECT idAtividade FROM atividade ORDER BY idAtividade DESC LIMIT 1");
if($consulta){
    while($atividade = mysql_fetch_object($consulta)){
	 $idAtividade = $atividade->idAtividade;
    }
    echo "<h4>".$idAtividade."</h4></br>";
}else{
    echo "<h4>Fai&ocirc; 2</h4></br>";
   }
$contador = 0;
 
 //inserindo o arquivo associado, se houver
if(isset($_FILES['arquivo']['tmp_name'])){
if(!is_null($_FILES['arquivo']['tmp_name'])){
    foreach($_FILES['arquivo']['tmp_name'] as $arquivo){
        $tamanho = $_FILES['arquivo']['size'][$contador];
        $tipo    = $_FILES['arquivo']['type'][$contador];
        $nome  = $_FILES['arquivo']['name'][$contador];
        $temp = $_FILES['arquivo']['tmp_name'][$contador];

        if ($arquivo != NULL && $arquivo != "none" ){
            $fp = fopen($arquivo, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);
        //}
            /*if(não tiver registro no banco infowebgerenciamento){
             * Fazer cópia do registro. GLPI -> Infowebgerenciamento
             * $query = "SELECT idUsuario FROM usuarios WHERE idUsuario = ".$responsavel;
             * $resultado = mysql_query($query);
             * if(mysql_num_rows($resultado)){
             *  
             * }
             * }*/
            $consulta =  mysql_query("INSERT INTO arquivo(`nomeArquivo`,`tipoArquivo`,`dataUpload`,`dataAlteracao`,`atividade_idAtividade`) VALUES ('".$nome."','".$tipo."',DATE('".date('Y-m-d')."'),DATE('0000-00-00'),'".$idAtividade."')") or die(mysql_error());
            $contador += 1;

            $path = "uploads/".$nomeAtividade."/";
            if(!is_dir($path)){
                mkdir($path,0777);}

            //Verificar permissão de acesso à pasta no servidor
            $teste = move_uploaded_file($temp, $path."/".$nome);// or die(mysql_error());
            if(!$teste){
                echo "<h4>Fai&ocirc; a parte do arquivo</h4></br>";
                echo $consulta."</br>";
            }

            if(!$consulta){echo "<h4>Fai&ocirc; 3 a consulta.</h4></br>";}
        }

    }
}
}

header( 'Location: /infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;
//header( 'Location: http://sefad.pmo.local/infowebgerenciamento/atividade.php?idProcesso='.$idProcesso ) ;
?>