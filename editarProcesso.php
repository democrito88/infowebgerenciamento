<?php
include 'php/funcoes.php';
include 'testelogin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"style="padding-right: 400px;"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFO WEB ADMINISTRATOR</title>
<?php cabecalho();?>
<!--
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
</script> -->
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<script type="text/javascript">
	function validateForm(form){
		nomeProcesso = document.form.nomeProcesso.value;
		dataInicial = document.form.dataInicial.value;
		dataFinal = document.form.dataFinal.value;
		situacao = document.form.situacao.value;
		status = document.form.status.value;
		responsavel = document.form.responsavel.value;
		
		if (nomeProcesso==null || nomeProcesso=="")
		  {
		  alert("Preencha o campo de nome do processo.");
		  return false;
		  }
		if (dataInicial==null || dataInicial=="")
		  {
		  //alert("Preencha o campo data inicial.");
		  //return false;
		  }
		if (dataFinal==null || dataFinal=="")
		  {
		  //alert("Preencha o campo data final.");
		  //return false;
		  }
		if (responsavel==null || responsavel=="")
		  {
		  alert("Preencha o campo do responsável.");
		  return false;
		  }
	  	if (status==0){
	  	  alert("Selecione um status.");
		  return false;
		 }else{
		
		document.form.submit();
		  }
	}
</script>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />

<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.css"/>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script>
$(function() {
    $("#calendario").datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat: 'dd-mm-yy',
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro']
		});
});

$(function() {
    $("#calendario1").datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat: 'dd-mm-yy',
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro']
		});
});
</script>
<style type="text/css">
h2 {
	margin-bottom: 20px;
	color: #474E69;
}

/* ===========================
   ====== Contact Form ======= 
   =========================== */

input, textarea {
	padding: 6px;
	border: 1px solid #E5E5E5;
	width: 200px;
	color: #999999;
	box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
	-moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;
	-webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 8px;		
}

textarea {
	width: 400px;
	height: 150px;
	max-width: 400px;
	line-height: 18px;
}

input:hover, textarea:hover,
input:focus, textarea:focus {
	border-color: 1px solid #C9C9C9;
	box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 8px;
	-moz-box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 8px;
	-webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 8px;	
}

.form label {
	margin-left: 10px;
	color: #999999;
}

/* ===========================
   ====== Submit Button ====== 
   =========================== */

.submit input {
	width: 100px; 
	height: 40px;
	background-color: #474E69; 
	color: #FFF;
	border-radius: 3px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;		
}
</style>
</head>
<body>
<div id="main_container">
 <div class="header">
    <div class="logo"><a href="index.php"><img src="images/logoci.png" alt="" title="" border="0" /></a></div>
    <div class="right_header"><?php menuUsuario();?>
  </div>
  <div class="main_content">
  	<div class="menu">
      <?php menuPrincipal(); ?>
    </div>
  	<div class="center_content">
    <?php
        conexaoInfoweb();
        $id = $_GET['idProcesso'];
    	$resultado = mysql_query("SELECT nomeProcesso, dataInicial, dataFinal, situacao, status, idUsuario, nomeUsuario FROM processo INNER JOIN usuario WHERE processo.usuario_idUsuario = usuario.idUsuario AND processo.idProcesso = ".$id);
        if($resultado != false){
            while($resultados = mysql_fetch_object($resultado)){
                $nomeProcesso = $resultados->nomeProcesso;
                $dataInicial = $resultados->dataInicial;
                $dataFinal = $resultados->dataFinal;
                $situacao = $resultados->situacao;
                $status = $resultados->status;
                $idUsuario = $resultados->idUsuario;
                $responsavel = $resultados->nomeUsuario;//selecionar o id do usuario também
            }

        }else{
            echo "erro: não foi possível realizar consulta no banco.";
        }
	?>
    <form name="form" id="form" action="atualizarProcesso.php?idProcesso=<?php echo $id;?>" method="post" onsubmit="return validateForm()">
    	<div align="center">Preencha os dados para cadastrar o processo<br/><br/>
            <p><input type="text" name="nomeProcesso" value="<?php echo $nomeProcesso;?>"/><label>Nome do processo</label></p>
            <p><input type="text" id="calendario" name="dataInicial" value="<?php echo date_format(date_create($dataInicial), "d-m-Y");?>"/><label>Data Inicial</label></p>
            <p><input type="text" id="calendario1" name="dataFinal" value="<?php echo date_format(date_create($dataFinal), "d-m-Y");?>"/><label>Data Final</label></p>
            <p><input type="text" name="situacao" value="<?php echo $situacao;?>" /><label>Situa&ccedil;&atilde;o</label></p>
            <p><select name="status" form="form">
                <option value="0">Selecione um status</option>
                <option value="1" <?php if($status == 1) echo "selected"; ?>>Aberto</option>
                <option value="2" <?php if($status == 2) echo "selected"; ?>>Executando</option>
                <option value="3" <?php if($status == 3) echo "selected"; ?>>Atrasado</option>
                <option value="4" <?php if($status == 4) echo "selected"; ?>>Cancelado</option>
                <option value="5" <?php if($status == 5) echo "selected"; ?>>Concluído</option>
            </select><label>Status</label></p>
            <p><?php echo updateSelectUsuario($idUsuario, $responsavel);?><label>Responsável</label></p>
        </div>
        <p align="center" class="submit">
            <input type="submit" onclick="validateForm(this.form)" value="Concluir" />
        </p>
    </form>
    
    </div>
    
  </div>
  <!--end of main content-->
  
  <div class="footer">
    <div class="left_footer">PAINEL DE ADMINISTRAÇÃO | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank"><div class="right_footer"></div></a>
  </div>
</div>
</body>
</html>