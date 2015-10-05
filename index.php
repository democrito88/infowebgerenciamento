<?php
include 'php/funcoes.php';
include 'testelogin.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
</head>
<body>
<div id="main_container">
  <div class="header">
    <div class="logo"><a href="index.php"><img src="images/logoci.png" alt="" title="" border="0" /></a></div>
    <div class="right_header">
     <?php menuUsuario();?>
    </div>
    <!-- </div>-->
    <div id="clock_a"></div>
  </div><!-- end of header-->
  <div class="main_content">
     <div class="menu">
     	<?php menuPrincipal(); ?>
    </div>
    <div class="center_content">
      <div class="left_content">
      <div id="cssmenu">
        <?php
            echo geraMenu2Wrapper();
        ?>
        </div>
        <!-- <div class="sidebar_box">
          <div class="sidebar_box_top"></div>
          <div class="sidebar_box_content">
            <h3>Gerenciamento</h3>
            <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
            <p>Crie processos, sub processos e ações com responsáveis e datas de início e fim de cada ação. Fique ligado! Não deixe sua árvore com galhos vermelhos e improdutivos.</p>
          </div>
          <div class="sidebar_box_bottom"></div>
        </div> -->
      </div>
      <div class="right_content">
        
    </div>
    <!--end of center content -->
    <div class="clear"></div>
  </div>
  <!--end of main content-->
  
  <div class="footer">
    <div class="left_footer">PAINEL DE ADMINISTRAÇÃO | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank">
    <div class="right_footer"></div>
    </a> </div> <!-- enf of footer-->
</div></div>
</body>
</html>