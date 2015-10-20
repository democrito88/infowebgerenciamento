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

<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />

<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.css"/>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>

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
	function validateForm(){
		nomeProcesso = document.form.nomeProcesso.value;
		dataInicial = document.form.dataInicial.value;
		dataFinal = document.form.dataFinal.value;
		situacao = document.form.situacao.value;
		status =  document.form.status.value;
		responsavel = document.form.responsavel.value;
		
		if (nomeProcesso==null || nomeProcesso=="")
		  {
		  alert("Preencha o campo de nome do processo.");
		  return false;
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
		return true;
		  }
	}
</script>

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
	padding: 10px;
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
  	<div align="center" style="padding:50px;">
    <form enctype="multipart/form-data" name="form" id="form" action="validarProcesso.php?idProcessoPai=<?php echo isset($_GET["idProcessoPai"])? $_GET["idProcessoPai"] : "0" ;?>" method="post" onsubmit="return validateForm()">
    	<div><h2>Preencha os dados para cadastrar o processo</h2><br/><br/>
            <p><input type="text" name="nomeProcesso"/><label>Nome do processo: </label></p>
            <p><input type="text" id="calendario" name="dataInicial"/><label>Data Inicial: </label></p>
            <p><input type="text" id="calendario1" name="dataFinal"/><label>Data Final: </label></p>
            <p><input type="text" name="situacao"/><label>Situa&ccedil;&atilde;o: </label></p>
            <p><select name="status" form="form">
                <option value="0">Selecione um status</option>
                <option value="1">Aberto</option>
                <option value="2">Executando</option>
                <option value="3">Atrasado</option>
                <option value="4">Cancelado</option>
                <option value="5">Concluído</option>
                </select></p>
            <p><?php selectUsuario()?><label>Responsável:</label></p>
        </div>
        <p class="submit">
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