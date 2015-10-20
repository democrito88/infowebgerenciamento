<?php
    //include 'php/conexao.php';
    include 'php/funcoes.php';
    include 'testelogin.php';

    //recebe o id do sub processo
    //$idProcesso = $_GET['idProcesso'];
    //$idAtividade = $_GET['idAtividade'];

    //atualiza o status das atividades colocando a marcatividade 'atrasado' (status = 3), se necessário
    atualizaStatus();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"style="padding-right: 400px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFO WEB ADMINISTRATOR</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
	function validateForm(){
		opcao = document.form.opcao.value;
		document.forms.submit();
		return true;
	}
	
	function baixar(idArquivo){
		//window.location.assign("http://sefad.pmo.local/infowebgerenciamento/baixar_arquivo.php?idArquivo="+idArquivo);
		window.location.assign("http://localhost/infowebgerenciamento/baixar_arquivo.php?idArquivo="+idArquivo);
		}
</script>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<style type="text/css">
.ui-dialog {
display: block;
    height: auto;
    left: 300px;
    position: absolute;
    top: 30px;
    width: 800px !important;
}
</style>
</head>
<body>
<div id="main_container">
<div style="margin-left:-220px;">
    <div class="menu">
      
    </div>
  <div class="center_content">
      
  </div>
    <!--end of center content -->
<div class="right_content" style="width:660px !important;">
      <h2 id="log">Minhas atividades</h2>
        <div>
<div id="detalhe">
        	<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
          <thead>
            <tr>
              <th scope="col" class="rounded-company">Nome</th>
              <th scope="col" class="rounded-company">Situa&ccedil;&atilde;o</th>
              <th scope="col" class="rounded">Data Inicial</th>
              <th scope="col" class="rounded">Data Final</th>
              <th scope="col" class="rounded">Status</th>
              <th scope="col" class="rounded">Pertece ao processo</th>
              <th scope="col" class="rounded">Editar</th>
              <th scope="col" class="rounded">Remover</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <?php
				
                //seleciona as atividades e seus respectivos arquivos
                /*if(isset($_GET['opcao']) && $_GET['opcao'] == 2){
                        $query = "SELECT * FROM acao WHERE (status = '4' OR status = '5') AND (processo_idProcessoProcesso = '".$idProcesso."')";
                        }
                else if(isset($_GET['opcao']) && $_GET['opcao'] == 1){
                        $query = "SELECT * FROM acao WHERE processo_idProcessoProcesso = ".$idProcesso;
                        }
                else{
                        $query = "SELECT * FROM acao WHERE (status = '1' OR status = '2' OR status = '3') AND (processo_idProcessoProcesso = '".$idProcesso."')";
                        }*/
                conexaoInfoweb();
                $dataAtual = date("Y/m/d");
                $idUsuario = $_GET['idUsuario'];
                $atividades = mysql_query("SELECT a.*, p.nomeProcesso, u.administrador FROM atividade a, processo p, usuario u WHERE a.usuario_idUsuario = ".$idUsuario." AND p.idProcesso = a.processo_idProcesso AND u.idUsuario = ".$idUsuario);

                //se não houver atividades atribuídas ao usuario
                if(mysql_num_rows($atividades) == 0){
              ?>
                <td colspan="8" class="rounded-foot-left"><em>Voc&ecirc; n&atilde;o possui atividades</em></td>
              <?php }
                //caso haja
                else{ ?>
                <td colspan="8" class="rounded-foot-left"><em>Estas s&atilde;o suas atividades</em></td>
                <?php } ?>
                <td class="rounded-foot-right">&nbsp;</td>
            </tr>
          </tfoot>
          <tbody>
         <?php
			
            if($atividades != false){				
                while($lista = mysql_fetch_object($atividades)){
                    $dataFinal = $lista->dataFinal;
                    //chama a função para subtrair datas passando a data final - data atual
                    $dias = subData($dataAtual,$dataFinal);

                    //imprime na cor definida
                    if($dias<=10){
                        echo "<tr class=\"red\">";
                    }else if($dias>=11 && $dias<=20){
                        echo "<tr class=\"yellow\">";
                    }else if($dias>20){
                        echo "<tr class=\"blue\">";
                    }

                    echo "<td>".$lista->nomeAtividade."</td>
                        <td>".$lista->situacao."</td>
                        <td>".date_format(date_create($lista->dataInicial), "d-m-Y")."</td>
                        <td>".date_format(date_create($lista->dataFinal), "d-m-Y")."</td>
                        <td>".status($lista->status)."</td>
                        <td>".$lista->nomeProcesso."</td>
                        <td><a href=\"editarAtividade.php?idAtividade=".$lista->idAtividade."&flag=true\"><img src=\"images/user_edit.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                        <td>".($lista->administrador == 1? "<a href=\"removerAtividade.php?idAtividade=".$lista->idAtividade."&flag=true&idUsuario=".$idUsuario."\" class=\"ask\"><img src=\"images/trash.png\" alt=\"\" title=\"\" border=\"0\" /></a>" : "<img src=\"images/trash2.png\">")."</td>
                        </tr>";

                }//fim while
            }else{
                echo "
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>";

            }
        ?>
          </tbody>
        </table>
        </div>
</div>
      <!-- end of right content--> 
    <div class="clear"></div>
  </div>
  <!--end of main content-->
  
  <!-- <div class="footer">
    <div class="left_footer">PAINEL DE ADMINISTRA&Ccedil;&Atilde;O | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank">
    <div class="right_footer"></div>
  </a> </div> -->
</div>
</body>
</html>