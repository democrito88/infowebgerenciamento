<?php
//include 'php/conexao.php';
include 'php/funcoes.php';
include 'testelogin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php cabecalho();?>

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
		idProcesso = document.form.idProcesso.value;
		alert("O id do processo é "+idProcesso);
		document.form.submit();
		return true;
	}
</script>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />

</head>
<body>
<div id="main_container">
  <div class="header">
    <div class="logo"><a href="index.php"><img src="images/logoci.png" alt="" title="" border="0" /></a></div>
    <div class="right_header">
	<?php
        $link = conexaoInfoweb();
        
        $login = $_SESSION['login']; 
        $consultaNomeUsuario = mysql_query("SELECT idUsuario, nomeUsuario, administrador FROM usuario WHERE login = '".$login."'");

        if(!$consultaNomeUsuario){
            $administrador = 0;
        }else{
            while($res = mysql_fetch_object($consultaNomeUsuario)){
                $administrador = $res->administrador;
            }
        }
        mysql_close($link);
        
        menuUsuario();?>
  </div>
  <div class="main_content">
    <div class="menu">
      <?php menuPrincipal(); ?>
    </div>
    <div class="center_content">
      <div class="left_content">
           <div id='cssmenu'>
          <?php
            conexaoInfoweb();
            echo geraMenu2Wrapper();
	    ?>     
        </div>
      </div><!-- end of left content -->
      <div class="right_content">
        <h2>Processos</h2>
        <div>
        	<form id="selecionar" action=<?php if(isset($_GET['idProcesso'])){echo "processo.php?idProcesso=".$_GET['idProcesso'];}else{echo "processo.php";} ?> >
            	<h4>Buscar processos:</h4>
            	<select name="opcao" form="selecionar">
                    <option value="0" selected="selected">Em aberto</option>
                    <option value="1">Todos</option>
                    <option value="2">Fechado</option>
                </select>
                <input type="submit" onclick="validateForm(this.form)" value="Buscar" />
            </form>
            <?php if(!isset($_GET['idProcesso'])){?>
        	<a href="cadastrarProcesso.php" class="bt_green"><span class="bt_green_lft"></span><strong>Adicionar Novo Processo Raiz</strong><span class="bt_green_r"></span></a>
            <?php }?>
        </div>
        <table id="rounded-corner" summary="2007 Major IT Companies' Profit">
          <thead>
            <tr>
              <th scope="col" class="rounded-company">Nome</th>
              <th scope="col" class="rounded">Data Inicial</th>
              <th scope="col" class="rounded">Data Final</th>
              <th scope="col" class="rounded">Status</th>
              <th scope="col" class="rounded">Editar</th>
              <th scope="col" class="rounded-q4">Remover</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td colspan="5" class="rounded-foot-left"><em><a onclick=""></a>Estes são os processos do sistema.</em></td>
              <td class="rounded-foot-right">&nbsp;</td>
            </tr>
          </tfoot>
          <tbody>
            <?php
            //caso os processos tenham um pai
            if(isset($_GET['idProcesso'])){
                $idProcesso = $_GET['idProcesso'];
                $query = "SELECT * FROM processo WHERE idProcessoPai = ".$idProcesso;
            }else{//caso não tenha pai
                if(isset($_GET['opcao']) && $_GET['opcao'] == 2){
                    $query = "SELECT * FROM processo WHERE (status = '4' OR status = '5' OR status = NULL) AND idProcessoPai IS NULL";
                }
                else if(isset($_GET['opcao']) && $_GET['opcao'] == 1){
                    $query = "SELECT * FROM processo";
                }
                else{
                    $query = "SELECT * FROM processo WHERE (status = '1' OR status = '2' OR status = '3' OR status IS NULL) AND idProcessoPai IS NULL";
                }
            }


            $processo = mysql_query($query);
            if($processo != false){
                while($processos = mysql_fetch_object($processo)){
                    if($processos->dataInicial == "0000-00-00" || $processos->dataInicial == NULL){ $dataInicial = "Não possui";}
                    else{$dataInicial = date_format(date_create($processos->dataInicial), "d-m-Y");}

                    if($processos->dataFinal == "0000-00-00" || $processos->dataInicial == NULL){ $dataFinal = "Não possui";}
                    else{$dataFinal = date_format(date_create($processos->dataFinal), "d-m-Y");}

                echo "<tr style=\"color:".substituiPorCores($processos->atraso)."\">
                    <td><a href=\"processo.php?idProcesso=".$processos->idProcesso."\">".$processos->nomeProcesso."</a></td>
                    <td>".$dataInicial."</td>
                    <td>".$dataFinal."</td>
                    <td>".status($processos->status)."</td>
                    <td>
                   <a href=\"editarProcesso.php?idProcesso=".$processos->idProcesso."\"><img src=\"images/user_edit.png\"></a>
                    </td>
                    <td>".(isset($administrador) && $administrador == 1? "<a href=\"removerProcesso.php?idProcesso=".$processos->idProcesso."\" class=\"ask\"><img src=\"images/trash.png\" alt=\"\" title=\"\" border=\"0\" /></a>" : "<img src=\"images/trash2.png\">")."
                    </td>
                  </tr>";
                }

            }else{
                echo "<tr>
                    <td>Falhou</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href=\"#\"><img src=\"images/user_edit.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                    <td><a href=\"#\" class=\"ask\"><img src=\"images/trash.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                  </tr>";
                }
        ?>
          </tbody>
        </table>
        <?php if(isset($_GET['idProcesso'])){?>
        <a href="cadastrarProcesso.php?idProcessoPai=<?php echo isset($_GET['idProcesso']) ? "".$_GET['idProcesso'] : "";?>" class="bt_green"><span class="bt_green_lft"></span><strong>Adicionar Novo Processo Nesta Categoria</strong><span class="bt_green_r"></span></a>
        <!-- <div class="pagination"></div> -->
        <?php }
            $query = !isset($_GET['idProcesso']) || $_GET['idProcesso'] == 0 ? "SELECT idProcessoPai FROM processo WHERE idProcesso IS NULL" : "SELECT idProcessoPai FROM processo WHERE idProcesso = ".$_GET['idProcesso'];
            $resultados = mysql_query($query);
            while($resultado = mysql_fetch_object($resultados)){
                $auxiliar = $resultado->idProcessoPai;

                if($auxiliar != "NULL"){
                    ?>
                    <p><a href="processo.php<?php echo isset($resultado->idProcessoPai) ? "?idProcesso=".$resultado->idProcessoPai : "";?>" class="bt_green"><span class="bt_green_lft"></span><strong>Voltar</strong><span class="bt_green_r"></span></a></p>
                    <?php
                }
            }
            ?>
      </div>
      <!-- end of right content--> 
    </div>
    <!--end of center content -->
    <div class="clear"></div>
  </div>
  <!--end of main content-->
  
  <div class="footer">
    <div class="left_footer">PAINEL DE ADMINISTRAÇÃO | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank"><div class="right_footer"></div></a>
  </div>
</div>
</body>
</html>