<?php

function cabecalho(){
    echo "<!--  para o menu-->
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<link rel=\"stylesheet\" href=\"css/cssmenu/styles.css\">
<script src=\"http://code.jquery.com/jquery-latest.min.js\" type=\"text/javascript\"></script>
<script src=\"css/cssmenu/script.js\"></script>

<!-- fim conf. para o menu-->

<title>INFO WEB ADMINISTRATOR</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
<script type=\"text/javascript\" src=\"js/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"js/ddaccordion.js\"></script>
<script type=\"text/javascript\">
ddaccordion.init({
	headerclass: \"submenuheader\", //Shared CSS class name of headers group
	contentclass: \"submenu\", //Shared CSS class name of contents group
	revealtype: \"click\", //Reveal content when user clicks or onmouseover the header? Valid value: \"click\", \"clickgo\", or \"mouseover\"
	mouseoverdelay: 200, //if revealtype=\"mouseover\", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: [\"\", \"\"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively [\"class1\", \"class2\"]
	togglehtml: [\"suffix\", \"<img src='images/plus.gif' class='statusicon' />\", \"<img src='images/minus.gif' class='statusicon' />\"], //Additional HTML added to the header when it's collapsed and expanded, respectively  [\"position\", \"html1\", \"html2\"] (see docs)
	animatespeed: \"fast\", //speed of animation: integer in milliseconds (ie: 200), or keywords \"fast\", \"normal\", or \"slow\"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<script type=\"text/javascript\" src=\"js/jconfirmaction.jquery.js\"></script>
<script type=\"text/javascript\">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});

	function validateForm(){
		opcao = document.form.opcao.value;
		idProcesso = document.form.idProcesso.value;
		alert(\"O id do processo é \"+idProcesso);
		document.form.submit();
		return true;
	}
</script>
<script language=\"javascript\" type=\"text/javascript\" src=\"js/niceforms.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"css/niceforms-default.css\" />

<!-- para o menu do usu&aacute;rio-->

<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js
\"></script>;
<script type=\"text/javascript\" >
$(document).ready(function()
{

$(\".account\").click(function()
{
var X=$(this).attr('id');
if(X==1)
{
$(\".submenu\").hide();
$(this).attr('id', '0');
}
else
{
$(\".submenu\").show();
$(this).attr('id', '1');
}

});

//Mouse click on sub menu
$(\".submenu\").mouseup(function()
{
return false
});

//Mouse click on my account link
$(\".account\").mouseup(function()
{
return false
});


//Document Click
$(document).mouseup(function()
{
$(\".submenu\").hide();
$(\".account\").attr('id', '');
});
});
</script>

<!-- fim menu usu&aacute;rio-->
";
	}
    
//include conexão
include 'conexao.php';

//para páginas de update
function updateSelectUsuario($idUsuario, $nomeUsuario){
    conexaoInfoweb();
    $query = "SELECT idUsuario, nomeUsuario FROM usuario WHERE nomeUsuario NOT LIKE \"".$nomeUsuario."\"";
    $resultado = mysql_query($query);

    echo "<select name=\"responsavel\" placeholder=\"responsavel\"><option value=\"".$idUsuario."\" selected=\"selected\">".$nomeUsuario."</option>";
    while($usuario = mysql_fetch_object($resultado)){
        $idUsuario = $usuario->idUsuario;
        $nomeUsuario = $usuario->nomeUsuario;
        echo "<option value=\"".$idUsuario."\">".$nomeUsuario."</option>";
    }
    mysql_close($link);
    
    //pega os usuários do banco GLPI
    $link = conexaoGLPI();
    $query = "SELECT id, firstname FROM glpi_users WHERE is_active = 1 AND firstname != \"\" AND firstname IS NOT NULL AND id != ".$idUsuario;
    $resultado = mysql_query($query);

    while($usuario = mysql_fetch_object($resultado)){
            $id = $usuario->id;
            $name = $usuario->firstname;
            echo "<option value=\"".$id."\">".$name."</option>";
            }
    mysql_close($link);
    
    echo "</select>";
}

//para páginas de cadastro
function selectUsuario(){
    $link = conexaoInfoweb();
    $query = "SELECT idUsuario, nomeUsuario FROM usuario";
    $resultado = mysql_query($query);

    echo "<select name=\"responsavel\" placeholder=\"responsavel\"><option value=\"\" selected=\"selected\">Selecione um usuario</option>";
    while($usuario = mysql_fetch_object($resultado)){
            $idUsuario = $usuario->idUsuario;
            $nomeUsuario = $usuario->nomeUsuario;
            echo "<option value=\"".$idUsuario."\">".$nomeUsuario."</option>";
            }
    mysql_close($link);
    
    //pega os usuários do banco GLPI
    $link = conexaoGLPI();
    $query = "SELECT id, firstname FROM glpi_users WHERE is_active = 1 AND firstname != \"\" AND firstname IS NOT NULL";
    $resultado = mysql_query($query);

    while($usuario = mysql_fetch_object($resultado)){
            $id = $usuario->id;
            $name = $usuario->firstname;
            echo "<option value=\"".$id."\">".$name."</option>";
            }
    mysql_close($link);
    echo "</select>";

    }

//"SELECT * FROM processo WHERE(DATEDIFF(dataFinal, CURDATE()) <= (0.2*DATEDIFF(dataFinal, dataInicial)))";
function verificaAtrasoProcesso($idProcesso){
    conexaoInfoweb();
    $query = "SELECT (DATEDIFF(dataFinal, CURDATE())/DATEDIFF(dataFinal, dataInicial)) AS diferenca FROM atividade WHERE processo_idProcesso = ".$idProcesso;
    $resultados = mysql_query($query);

    //valores iniciais
    $corAtividade = 3;
    $corProcessoFilho = 3;

    while($resultado = mysql_fetch_object($resultados)){
            $diferenca = $resultado->diferenca;

            if($diferenca > 0.2){

            }else if($diferenca < 0.2 && $diferenca > 0.1){

            }else{

            }
            //caso não tenha filhos
    $num = mysql_num_rows($resultados);
    if($num == 0){
    }else{
    }

    }

    return $corProcesso;
}

function atualizaStatus(){
    conexaoInfoweb();
    $query = "UPDATE atividade SET status='3' WHERE (DATEDIFF(dataFinal, CURDATE()) < 1) AND (status = '1' OR status = '2')";
    mysql_query($query);
}

function selectArquivos($idAtividade){
    conexaoInfoweb();
    $query  = "SELECT idArquivo, nomeArquivo FROM arquivo WHERE atividade_idAtividade = ".$idAtividade;
    $resultado = mysql_query($query);

    //se houver arquivos associados � atividade
    if($resultado != false){
            if(mysql_num_rows($resultado) > 1){
                    $retorno =  "<form name='form' \"><select name='arquivo' form='form'>";
                    while($arquivo = mysql_fetch_object($resultado)){
                            $retorno = $retorno."<option onclick=\"baixar(".$arquivo->idArquivo.")\">".$arquivo->nomeArquivo."</option>";
                    }
                    $retorno = $retorno."</select></form>";
            }else if(mysql_num_rows($resultado) == 1){
                    while($arquivo = mysql_fetch_object($resultado)){
                            $retorno = "<a  name=\"".$arquivo->nomeArquivo."\" href=\"arquivos/baixar_arquivo.php?idArquivo=".$arquivo->idArquivo."\">".$arquivo->nomeArquivo."</a>";
                    }
                    }else{
                            $retorno = "N&atilde;o possui";
                            }

    }else{
            $retorno = "erro SQL";
            }
    return $retorno;
}

//retorna o nome correspondente ao número de status
function status($valor){
    switch($valor){
            case '1': return "Aberto";
            case '2': return "Executando";
            case '3': return "Atrasado";
            case '4': return "Cancelado";
            case '5': return "Conclu&iacute;do";
            default: return "N&atilde;o definido";
            }
}

function diferencaData($data1,$data2) {

    date_default_timezone_set('America/Sao_Paulo');

    $inicio = date("d/m/Y", strtotime($data1));
    $fim = date("d/m/Y", strtotime($data2));

    // Converte as datas para objetos DateTime do PHP
    // PARA O PHP 5.3 OU SUPERIOR
    $inicio = DateTime::createFromFormat('d/m/Y', $inicio);
    //PARA O PHP 5.2
    // $inicio = date_create_from_format('d/m/Y H:i:s', $inicio);

    $fim = DateTime::createFromFormat('d/m/Y', $fim);
    // $fim = date_create_from_format('d/m/Y H:i:s', $fim);

    // Calcula a diferença entre as duas datas
    $intervalo = $inicio->diff($fim);

    // Imprime a diferença entre as duas
    // datas de modo formatado
    //	print $intervalo->format('%a');
    return $intervalo->format('%a');
}


//função para subtrair data
function subData($data1, $data2){

    // Usa a função strtotime() e pega o timestamp das duas datas:
    $time_inicial = strtotime($data1);
    $time_final = strtotime($data2);

    // Calcula a diferenÃ§a de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial; 

    // Calcula a diferenÃ§a de dias
    $dias = (int)floor( $diferenca / (60 * 60 * 24)); 
    return $dias;

}

function atualizaAtrasoWrapper(){
    conexaoInfoweb();
    $query = "SELECT idProcesso FROM processo WHERE idProcessoPai IS NULL";
    $processos = mysql_query($query);
    while($processo = mysql_fetch_object($processos)){
            atualizaAtraso($processo->idProcesso);
    }
}	

function atualizaAtraso($idProcesso){
    conexaoInfoweb();
    
    //seleciona os que já passaram de 80 e 90% do tempo determminado
    $query = "SELECT IF( DATEDIFF( dataFinal, CURDATE( ) ) < ( 0.1 * DATEDIFF( dataFinal, dataInicial ) ) , 'true', 'false' ) diferenca,
                    IF( DATEDIFF( dataFinal, CURDATE( ) ) < ( 0.2 * DATEDIFF( dataFinal, dataInicial ) ) , 'true', 'false' ) diferenca2
                    FROM atividade WHERE processo_idProcesso = ".$idProcesso." AND (status =1 OR status =2 OR status =3)";
    $resultados = mysql_query($query);
    $atraso = 3;

    /*CALCULAR A DATA DAS ATIVIDADES COM BASE NA DATA DELAS, NÃO DE SEU PROJETO PAI*/
    //procura o maior atraso de suas atividades, se houverem
    if(mysql_num_rows($resultados) != 0){
        while($atividade = mysql_fetch_object($resultados)){
            $diferenca = $atividade->diferenca;
            $diferenca2 = $atividade->diferenca2;
            /*$diferenca = subData($atividade->dataInicial, $atividade->dataFinal);
            if($diferenca <= 10){
                    $auxiliar = 3;
            }else if($diferenca > 10 && $diferenca < 20){
                    $auxiliar = 2;
            }else{
                    $auxiliar = 1;
            }*/
            $diferenca2 == "true" ? $diferenca == "true" ? $auxiliar = 1 : $auxiliar = 2 : $auxiliar = 3;
            if($auxiliar < $atraso)
                    $atraso = $auxiliar;
        }
    }

    //procura processos filhos, se houverem
    $query = "SELECT idProcesso FROM processo WHERE idProcessoPai = ".$idProcesso;
    $resultados = mysql_query($query);
    if(mysql_num_rows($resultados) != 0){
        while($processoFilho = mysql_fetch_object($resultados)){
            $atrasoFilho = atualizaAtraso($processoFilho->idProcesso);

            if($atraso > $atrasoFilho){
                    $atraso = $atrasoFilho;
            }
        }
    }

    //atualiza no banco o novo resultado
    $query = "UPDATE processo SET atraso = '".$atraso."' WHERE idProcesso = ".$idProcesso;
    $resultados = mysql_query($query);

    //retorna para ser usado nas chamadas recursivas
    return $atraso;
}

function substituiPorCores($atraso){
    switch($atraso){

        case '1': return "red";
        case '2': return "yellow";
        case '3': return "white";
        default: return 'white';
    }
}

//função que encapsula a que gera o menu
function geraMenu2Wrapper(){
    $retorno = "<ul>\n";
    $retorno = $retorno.geraMenu2(NULL);
    $retorno = $retorno."\n</ul>\n";
    return $retorno;
}

//veriifica se o processo tem filhos para auxiliar na montagerm do menu
function temFilho($idProcesso){
    conexaoInfoweb();
    
    $query2 = $idProcesso == NULL ? "SELECT COUNT(idProcesso) AS temFilho FROM processo WHERE idProcessoPai IS NULL" : "SELECT COUNT(idProcesso) AS temFilho FROM processo WHERE idProcessoPai = ".$idProcesso;
    $resultados = mysql_query($query2);
    
    while($resultado = mysql_fetch_object($resultados)){
        $num = $resultado->temFilho;
    }
    return $num;
}

function geraMenu2($idProcessoPai){
    conexaoInfoweb();
    $query = $idProcessoPai == NULL ? "SELECT nomeProcesso, idProcesso, atraso FROM processo WHERE idProcessoPai IS NULL" : "SELECT nomeProcesso, idProcesso, atraso FROM processo WHERE idProcessoPai = ".$idProcessoPai;
    $resultados = mysql_query($query) or die('Could not connect: '.mysql_error());
    $retorno = "";

    while($resultado = mysql_fetch_object($resultados)){
            $num = temFilho($resultado->idProcesso);
            
            //caso não tenha filhos
            if($num == 0){
                $retorno = $retorno."<li class=\"last\"><a style=\"color:".substituiPorCores($resultado->atraso)."\" href=\"atividade.php?idProcesso=".$resultado->idProcesso."\"><span>".$resultado->nomeProcesso."</span></a></li>\n";
            }else{
            //caso tenha

                $retorno = $retorno."<li class=\"has-sub\"><a style=\"color:".substituiPorCores($resultado->atraso)."\" href=\"atividade.php?idProcesso=".$resultado->idProcesso."\"><span>".$resultado->nomeProcesso."</span></a>\n<ul>\n";
                $idProcesso = $resultado->idProcesso;
                $retorno = $retorno."\t".geraMenu2($idProcesso);
                $retorno = $retorno."</ul>\n</li>\n";
            }

    }
    return $retorno;
}

function listaProcessosWrapper($idProcessoPaiOriginal){
    $retorno = "<select name=\"processoPai\" placeholder=\"processoPai\">\n";
    $retorno = $retorno.listaProcessos("",NULL,$idProcessoPaiOriginal);
    $retorno = $retorno."\n</select>\n";
    return $retorno;
}

function listaProcessos($nivel,$idProcessoPai,$idProcessoPaiOriginal){
    conexaoInfoweb();
    
    $query = $idProcessoPai == NULL ? "SELECT nomeProcesso, idProcesso FROM processo WHERE idProcessoPai IS NULL" : "SELECT nomeProcesso, idProcesso FROM processo WHERE idProcessoPai = ".$idProcessoPai;
    $resultados = mysql_query($query);
    $retorno = "";

    while($resultado = mysql_fetch_object($resultados)){
        $num = temFilho($resultado->idProcesso);

        //caso não tenha filhos
        if($num == 0){
            $retorno = $resultado->idProcesso == $idProcessoPaiOriginal? $retorno."<option selected=\"selected\" value=\"".$resultado->idProcesso."\">".$nivel.$resultado->nomeProcesso."</option>\n" : $retorno."<option value=\"".$resultado->idProcesso."\">".$nivel.$resultado->nomeProcesso."</option>\n";
        }else{
        //caso tenha

            $retorno = $resultado->idProcesso == $idProcessoPaiOriginal? $retorno."<option selected=\"selected\" value=\"".$resultado->idProcesso."\">".$nivel.$resultado->nomeProcesso."</option>\n" : $retorno."<option value=\"".$resultado->idProcesso."\">".$nivel.$resultado->nomeProcesso."</option>\n";
            $nivelAnterior = $nivel;
            $nivel = $nivel."-";
            $retorno = $retorno.listaProcessos($nivel, $resultado->idProcesso, $idProcessoPaiOriginal);
            $nivel = $nivelAnterior;
        }
    }
    return $retorno;
}

function formataData($data){
    $arrayData = array();
    $pos = 0;
    $posc = 0;
    $caractere = array();
    for($i=0; $i<strlen($data); $i++){ 
        if($data[$i] != "-"){
            $caractere[$posc] = $data[$i];
            $posc += 1;
            }else{
                $arrayData[$pos] = "".$caractere;
                $pos += 1;
                $posc = 0;
            }
    }
}

//17/07/2005: fazer o método consultar 2 bancos. Atualmente, s� consulta glpi
function menuUsuario(){
    $link = conexaoGLPI();
    $login = $_SESSION['login'];
    /*para se conectar com o banco do GLPI
    $link = mysql_connect('localhost', 'root', 'B@nc0NEW', true);
    if (!$link) {
        die('Could not connect: '.mysql_error() );
    }

    $base2 = mysql_select_db('sefad_glpi',$link) or die ("could not open db".mysql_error());*/

    $query = "SELECT id, name FROM glpi_users WHERE name = '".$login."'";
    $consulta = mysql_query($query, $link);
    
    if(mysql_num_rows($consulta) != 0){
        $glpi = true;
        while($resultado = mysql_fetch_object($consulta)){
            $nomeUsuario = $resultado->name;
            $idUsuario = $resultado->id;
            $administrador = 0;
        }

        mysql_close($link); //fecha a conexão com o banco do glpi
    }else {
        $glpi = false;
        mysql_close($link); //fecha a conexão com o banco do glpi

        //consulta no banco próprio (infowebgerenciamento)
        $link = conexaoInfoweb();
        $consultaNomeUsuario = mysql_query("SELECT idUsuario, nomeUsuario, administrador FROM usuario WHERE login = '" . $login . "'");

        while ($res = mysql_fetch_object($consultaNomeUsuario)) {
            $nomeUsuario = $res->nomeUsuario;
            $administrador = $res->administrador;
            $idUsuario = $res->idUsuario;
        }
    }

//---------------------			*/
    if($glpi){
        echo "<div class=\"dropdown\">
            <a class=\"account\"> ".$nomeUsuario."</a>
            <div class=\"submenu\">
                    <ul class=\"root\">
                    <li><a href=".($administrador == 1 ? "usuarios.php?idUsuario=".$_SESSION['id'].">dados dos usu&aacute;rios</a>" : "editarUsuario.php?idUsuario=".$_SESSION['id'].">meus dados</a>")."</li>
                    <li><a href='#' onclick=window.open('minhasAtividades.php?idUsuario=".$idUsuario."','teste','width=800,height=400')>minhas atividades</a></li>
                    <li><a href=\"sair.php?nomeUsuario=".$nomeUsuario." class=\"logout\">Sair</a></li>
                </ul>
            </div> <!-- fim submenu-->
        </div><!-- fim dropdown-->";
    }else{
        echo "<div class=\"dropdown\">
            <a class=\"account\"> ".$nomeUsuario."</a>
            <div class=\"submenu\">
                    <ul class=\"root\">
                    <li><a href=".($administrador == 1 ? "usuarios.php?idUsuario=".$_SESSION['id'].">dados dos usu&aacute;rios</a>" : "editarUsuario.php?idUsuario=".$_SESSION['id'].">meus dados</a>")."</li>
                    <li><a href='#' onclick=window.open('minhasAtividades.php?idUsuario=".$idUsuario."','teste','width=800,height=400')>minhas atividades</a></li>
                    <li><a href=\"sair.php?nomeUsuario=".$nomeUsuario." class=\"logout\">Sair</a></li>
                </ul>
            </div> <!-- fim submenu-->
        </div><!-- fim dropdown-->";
    }
    return $administrador;
}

function menuPrincipal(){
    echo "
    <ul>
        <li><a class=\"current\" href=\"index.php\">HOME</a></li>
        <li><a href=\"processo.php\">PROCESSO</a></li>
        <li><a href=\"http://informatica.olinda.pe.gov.br/coordinfo/infoweb/front/helpdesk.php\" target=\"_blank\">ATENDIMENTO</a></li>
        <li><a href=\"http://informatica.olinda.pe.gov.br\" target=\"_blank\">INFORMÁTICA</a></li>
        <li><a href=\"glpiIntegracao.php\">GLPI</a></li>
    </ul>";
    }

function traduzStatus($status){
	
    switch($status){
        case 'new': return 'novo';
        case 'assign': return 'atribu&iacute;do';
        case 'solved': return 'resolvido';
        case 'closed': return 'fechado';
        default: return '';
    }
}

	/*
	
	//imprime o menu com as cores
function geraMenu(){
	$query = "SELECT atraso FROM processo ORDER BY idProcesso";
	$array = array();
	$index = 0;
	$resultado = mysql_query($query);
	while($processo = mysql_fetch_object($resultado)){
		$array[$index] = $processo->atraso;
		$index += 1;
	}
	
	echo "
<div id='cssmenu'>
<ul>
        <li class=\"has-sub\">
        	<a  href=\"#\" style=\"color:".substituiPorCores($array[0])."\"><span>Licitações e Contratos</span></a>
            <ul>
            	<li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[1])."\" href=\"#\"><span>Licitações</span></a>
                	<ul>
                    	<li class=\"last\"><a style=\"color:".substituiPorCores($array[0])."\" href=\"#\"><span>licitação1</span></a></li>
                        <li class=\"last\"><a style=\"color:".substituiPorCores($array[0])."\" href=\"#\"><span>licitação2</span></a></li>
                    </ul>
                </li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[2])."\" ><span>Contratos</span></a></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[3])."\" href=\"#\"><span>Desenvolv. e Customização</span></a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[4])."\"><span>Desenvolvimento</span></a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[5])."\"><span>Customização</a></span></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[6])."\" href=\"#\">Manutenção e Atendimento</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[7])."\">Man. corretiva preventiva</a></li>
                 <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[31])."\" href=\"#\">Atendimentos</a>
                    <ul>
                          <li class=\"last\"><a style=\"color:".substituiPorCores($array[8])."\">de 1º grau</a></li>
                          <li class=\"last\"><a style=\"color:".substituiPorCores($array[9])."\">de 2º grau</a></li>
                          <li class=\"last\"><a style=\"color:".substituiPorCores($array[10])."\">de 3º grau</a></li>
                    </ul>
                </li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[11])."\" href=\"#\">Infraestrutura</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[12])."\">Data Center</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[13])."\">Redes Estabilizadas</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[14])."\">Rede Lógica</a></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[15])."\" href=\"#\">Rede MAN</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[16])."\">Monitoramento e Manutenção MAN</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[17])."\">Novos Pontos</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[18])."\">Pontos 3CNET</a></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[19])."\" href=\"#\">Processos e Planejamento</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[20])."\">Processos</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[21])."\">Planejamento</a></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[22])."\" href=\"#\">Gestão de Servidores</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[23])."\">AD</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[24])."\">Antivírus</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[25])."\">VMware</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[26])."\">Correio</a></li>
            </ul>
        </li>
         <li class=\"has-sub\"><a style=\"color:".substituiPorCores($array[27])."\" href=\"#\">Núcleo de Segurança</a>
        	<ul>
            	<li class=\"last\"><a style=\"color:".substituiPorCores($array[28])."\">Monitoramento</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[29])."\">Ações de Auditoria</a></li>
                <li class=\"last\"><a style=\"color:".substituiPorCores($array[30])."\">Pen testes</a></li>
            </ul>
        </li>
        
      </ul>
      </div>";
}
	
	//Função para criar o menu
	function creatMenu(){
		
		//função para criar os menus e sub menus com as cores indicadas
		//cor 1 = vermelho
		//cor 2 = amarelo
		//cor 3 = azul
		$dataAtual = date("Y/m/d");
		$pro = mysql_query("SELECT idProcesso, nomeProcesso FROM processo WHERE status = 1 OR status = 2 OR status = 3 OR status IS NULL");
		$numero = mysql_num_rows($pro);
		
		while($res = mysql_fetch_object($pro)){			
			$idProcesso = $res->idProcesso;
			$nomeProcesso = $res->nomeProcesso;
			
			$coresSubProcesso = array();//array de cores do subprocesso
			$cont = 0;//para manipular o array
			$arrayAcao = array();//armazena se os subprocessos possui acao ou não (T/F)
			$contador = 0;//contador para o arrayAcao
			$sub = mysql_query("SELECT idSubProcesso, nomeSubProcesso FROM subprocesso WHERE Processo_idProcesso = ".$idProcesso);
			$cor = 0;
			$corP = 3;//valores iniciais das cores
		 	while($subProcessos = mysql_fetch_object($sub)){				
				$idSubProcesso = $subProcessos->idSubProcesso;
				$nomeSub = $subProcessos->nomeSubProcesso;
				$acoes = mysql_query("SELECT dataFinal FROM acao WHERE subProcesso_idSubProcesso = ".$idSubProcesso." AND (status = 1 OR status = 2 OR status = 3 OR status IS NULL)");
				$arrayAcao[$contador] = mysql_affected_rows();
				$contador +=1;
				$corSub = 3;//cor inicial do sub processo
				while($lista = mysql_fetch_object($acoes)){					
					$dataFinal = $lista->dataFinal;
					//chama a função para subtrair datas passando a data final - data atual
					$dias = subData($dataAtual,$dataFinal);

					if($dias<=10){
						$cor = 1;
						$processo = $idProcesso;
						//echo "id ".$idSubProcesso."<br />";
						//echo "cor ".$cor."<br />";
					}else if($dias>10 && $dias<=20){
						$cor = 2;
						$processo = $idProcesso;
						//echo "id ".$idSubProcesso."<br />";
						//echo "cor ".$cor."<br />";			
					}else if($dias>20){
						$cor = 3;
						$processo = $idProcesso;
						//echo "id ".$idSubProcesso."<br />";
						//echo "cor ".$cor."<br />";
					}
					
					if($cor < $corP){
						$corP = $cor;
					}
					if($cor < $corSub){
						$corSub = $cor;
					}
		
				}//fim while acao
				$coresSubProcesso[$cont] = $corSub;
				$cont += 1;
			}//fim while subProcesso/
				$contador = 0;
				if($arrayAcao!= NULL && $arrayAcao[$contador] != 0){//se houver alguma ação cadastrada
					if($corP == 3){ 
						echo "<a class='menuitem submenuheader' href=''>".$res->nomeProcesso."</a>";		
					}else if($corP == 2){
						echo "<a class='menuitem_yellow submenuheader' href=''>".$res->nomeProcesso."</a>";		
					}else if($corP == 1){
						echo "<a class='menuitem_red submenuheader' href=''>".$res->nomeProcesso."</a>";
					} 
					echo "<div class=\"submenu\"><ul>";
					
					$sub = mysql_query("SELECT idSubProcesso, nomeSubProcesso FROM subprocesso WHERE Processo_idProcesso = ".$idProcesso);
					
					$cont = 0;
					while($subProcessos = mysql_fetch_object($sub)){
						
						$idSubProcesso = $subProcessos->idSubProcesso;
						$nomeSub = $subProcessos->nomeSubProcesso;
						
						if($coresSubProcesso[$cont] == 1){
							echo "<li><a style=\"color:#F00\" href=\"acao.php?opcao=0&idSub=".$idSubProcesso."\">".$nomeSub."</a></li>";
						}else if($coresSubProcesso[$cont] == 2){
							echo "<li><a style=\"color:#FF6600\" href=\"acao.php?opcao=0&idSub=".$idSubProcesso."\">".$nomeSub."</a></li>";					
						}else if($coresSubProcesso[$cont] == 3){
							echo "<li><a style=\"color:#0000FF;\" href=\"acao.php?opcao=0&idSub=".$idSubProcesso."\">".$nomeSub."</a></li>";
							}		
						$cont = $cont+1;
					}	
						echo "<a class='menuitem_green' href='cadastrarSubProcesso.php?idProcesso=".$idProcesso."'>Add Sub Processo</a></ul></div>";
					}else{//se não houver ação cadastrada ATENÇÃO!!!!!
						echo "<a class='menuitem submenuheader' href=''>".$res->nomeProcesso."</a>";		
						echo "<div class='submenu'><ul>";
						$sub = mysql_query("select * from subprocesso where Processo_idProcesso = ".$idProcesso);
						
						while($subProcessos = mysql_fetch_object($sub)){
							$idSubProcesso = $subProcessos->idSubProcesso;
							$nomeSub = $subProcessos->nomeSubProcesso;
							echo "<li><a href=\"acao.php?idSub=".$idSubProcesso."\">".$nomeSub."</a></li>";
						}
						
						echo "<a class='menuitem_green' href='cadastrarSubProcesso.php?idProcesso=".$idProcesso."'>Adicionar Subprocesso</a></ul></div>";
				
				}
				
				
		}//fim while processo
			
	}//fim creatMenu
	
	function imprimirFilhos($idProcesso){
	$query = "SELECT idProcesso, nomeProcesso FROM processo WHERE idProcessoPai = ".$idProcesso;	
	$busca = mysql_query($query);
	//$aux = mysql_affected_rows($busca);
	if($busca){
		while($processo = mysql_fetch_object($busca)){
			
			//caso o processo não tenha processos filhos
			//if(mysql_affected_rows($resultadoAtividade) != 0){
			//	echo "<li><a href=\"acao.php?idProcesso=".$idProcesso."\">".$processo->nomeProcesso."</a></li>";
			//}else{
				//caso tenha
				echo "<li><a href=\"acao.php?idProj=".$processo->idProcesso."\">".$processo->nomeProcesso."</a>";
				//imprime seus filhos, se houver
				imprimirFilhos($processo->idProcesso);
				echo "</li>";
			//}
			
		}
	}else{
		echo "<h4>Faiô<h4>";
		}
}

function imprimeMenu(){
	$query = "SELECT idProcesso, nomeProcesso FROM processo WHERE idProcessoPai IS NULL";
	$resultado = mysql_query($query);
	
	while($processoPai = mysql_fetch_object($resultado)){
		echo "<a class='menuitem submenuheader' href=''>".$processoPai->nomeProcesso."</a>";
		echo "<div class=\"submenu\"><ul>";
		imprimirFilhos($processoPai->idProcesso);
		echo "<a class='menuitem_green' href='cadastrarSubProcesso.php?idProcesso=".$processoPai->idProcesso."'>Add Sub Processo</a></ul></div>";
	}
}

	*/

?>