<?php include 'php/conexao.php'; ?>

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
		nome = document.form.nome.value;
		login = document.form.login.value;
		senha = document.form.senha.value;
		email =  document.form.email.value;
		
		
		//valida email
		var atpos=email.indexOf("@");
		var dotpos=email.lastIndexOf(".");
		
		if (nome==null || nome=="")
		  {
		  alert("Preencha o campo de nome.");
		  return false;
		  
		  }
		else if (login==null || login=="")
		  {
		  alert("Preencha o campo de login.");
		  return false;
		  }
		else if (senha == null || senha == ""){
		  alert("Preencha o campo de senha.");
		  return false;
		  }
		else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
		  {
		  alert("Escreva um endereço de email válido.");
		  return false;
		  }
		else if (email==null || email=="")
		  {
		  alert("Preencha o campo de email.");
		  return false;
		  }else{
			document.form.submit();
			return true;
		  }
	}
</script>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
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
    <div class="logo"><a href="index.html"><img src="images/logoci.png" alt="" title="" border="0" /></a></div>
    <div class="right_header"></div>
    <div id="clock_a"></div>
  </div>
  <div class="main_content">
    <div class="menu">
    </div>
    <div class="center_content">
      <div class="left_content">
      <div class="sidebarmenu">
              
        </div>
        <div class="sidebar_box">
          <div class="sidebar_box_top"></div>
          <div class="sidebar_box_content">
            <h3>Gerenciamento</h3>
            <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
            <p>Crie projetos, sub projetos e ações com responsáveis e datas de início e fim de cada ação. Fique ligado! Não deixe sua árvore com galhos vermelhos e improdutivos.</p>
          </div>
          <div class="sidebar_box_bottom"></div>
        </div>
      </div>
      <div class="right_content">
		 <h3>Página de cadastro</h3>
          <form name="form" action="validarUsuario.php" method="post" class="form">
            <fieldset>
              <dl>
                <dt>
                  <label for="nome">Nome do usuário:</label>
                </dt>
                <dd>
                  <input type="text" name="nome" id="" size="54" />
                </dd>
              </dl>
              <dl>
                <dt>
                  <label for="login" >Nome para login:</label>
                </dt>
                <dd>
                  <input type="text" name="login" id="" size="54" />
                </dd>
              </dl>
              <dl>
                <dt>
                  <label for="senha" >Senha:</label>
                </dt>
                <dd>
                  <input type="password" name="senha" id="" size="54" />
                </dd>
              </dl>
              <dl>
                <dt>
                  <label for="email">Email:</label>
                </dt>
                <dd>
                  <input type="text" name="email" id="" size="54" />
                </dd>
              </dl>
              <dl class="submit">
                <input onclick="validateForm()" type="submit" name="submit" id="submit" value="Concluir" />
              </dl>
            </fieldset>
          </form>
        </div>
      
      <div class="clear"></div>
      <!-- end of right content--> 
    </div>
    <!--end of center content --> 
    

  <!--end of main content-->
  
  <div class="footer" align="right">
    <div class="left_footer">PAINEL DE ADMINISTRAÇÃO | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank">
    <div class="right_footer"></div>
    </a> </div>
</div></div>
</body>
</html>