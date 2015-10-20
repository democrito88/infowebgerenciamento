<?php
include 'php/funcoes.php';
include 'testelogin.php';

//atualiza o status das atividades colocando a marca��o 'atrasado' (status = 3), se necess�rio
//atualizaStatus();
conexaoInfoweb();
atualizaAtrasoWrapper();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"style="padding-right: 400px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFO WEB ADMINISTRATOR</title>
<?php  cabecalho(); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	function validateForm(){
            opcao = document.form.opcao.value;
            //document.form.submit();
            window.location.assign("http://localhost/infowebgerenciamento/glpiIntegracao.php?opcao="+opcao);
            return true;
	}
	function baixar(idArquivo){
		//window.location.assign("http://sefad.pmo.local/infowebgerenciamento/arquivos/baixar_arquivo.php?idArquivo="+idArquivo);
		window.location.assign("http://localhost/infowebgerenciamento/arquivos/baixar_arquivo.php?idArquivo="+idArquivo);
		}
</script>
</head>
<body>
<div id="main_container">
  <div class="header">
    <div class="logo"><a href="index.php"><img src="images/logoci.png" alt="" title="" border="0" /></a></div>
    <div class="right_header"><?php menuUsuario();?>
  </div>
  <div class="main_content">
    <div class="menu">
      <?php menuPrincipal();?>
    </div>
    <div class="center_content">
      <div class="left_content">
        <div id='cssmenu'>
          <?php
            conexaoInfoweb();
            echo geraMenu2Wrapper();
            ?>     
        </div>
        <div class="sidebar_box">
          <!-- <div class="sidebar_box_top"></div>
           <div class="sidebar_box_content">
            <h3>Gerenciamento</h3>
            <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
            <p>Crie processos, sub processos e aÃ§Ãµes com responsÃ¡veis e datas de inÃ­cio e fim de cada aÃ§Ã£o. Fique ligado! NÃ£o deixe sua Ã¡rvore com galhos vermelhos e improdutivos.</p>
          </div>
          <div class="sidebar_box_bottom"></div>
        </div> -->
      </div> <!--end of left content-->
      
    </div>
    <!--end of center content -->
    <div class="right_content">
        <h2 id="atividade">Atividades no sistema glpi</h2>
        <table id="rounded-corner" summary="2007 Major IT Companies' Profit" style="width:870px">
          <thead>
            <tr>
              <th scope="col" class="rounded-company">Solicitante</th>
              <th scope="col" class="rounded">Ocorr&ecirc;ncia</th>
              <th scope="col" class="rounded">Em</th>
              <th scope="col" class="rounded">Data de Modifica&ccedil;&atilde;o</th>
              <?php echo isset($_GET['opcao']) && !is_null($_GET['opcao']) ? "<th scope=\"col\" class=\"rounded\">Atribu&iacute;do para</th>" : "<th scope=\"col\" class=\"rounded\">Atribu&iacute;do por</th>"; ?>
              <th scope="col" class="rounded">Status</th>
              <th scope="col" class="rounded">Ver no GLPI</th>
            </tr>
              
          </thead>
          <tfoot>
            <tr>
              <td colspan="8" class="rounded-foot-left"><em>Estes s&atilde;o os chamados mais recentes no sistema GLPI.</em></td>
              <td class="rounded-foot-right">&nbsp;</td>
            </tr>
          </tfoot>
         <?php
                       
            //para se conectar com o banco do GLPI
            /*$link = mysql_connect('localhost', 'root', '', true);
            if (!$link) {
            die('Could not connect: '.mysql_error() );
            }

            $base2 = mysql_select_db('sefad_glpi',$link) or die ("could not open db".mysql_error());*/

            //verificar se esta query funciona com os ``
            $link = conexaoGLPI();
            $query = "SELECT firstname, id FROM glpi_users WHERE id >5 AND id IS NOT NULL AND is_active >0 AND firstname NOT LIKE \"\" LIMIT 30";
            $consulta = mysql_query($query,$link);
            
            $characteres = array(
            'Å '=>'S', 'Å¡'=>'s', 'Ã�?'=>'Dj','Å½'=>'Z', 'Å¾'=>'z', 'À'=>'&Agrave;', '�?'=>'&Aacute;', 'Â'=>'&Acirc;', 'Ã'=>'&Atilde;', 'Ä'=>'&Auml;',
            'Ã…'=>'&Aring;', 'Ã†'=>'&aelig;', 'Ç'=>'&Ccedil;', 'Ê'=>'&Egrave;', 'É'=>'&Eacute;', 'Ê'=>'&Ecirc;', 'Ë'=>'&Euml;', 'Î'=>'&Igrave;', '�?�?'=>'&Iacute;', 'Î'=>'&Icirc;',
            '�?'=>'&Iuml;', 'Ñ'=>'&Ntilde;', 'Ò'=>'&Ograve;', 'Ó'=>'&Oacute;', 'Ô'=>'&Ocirc;', 'Õ'=>'&Otilde;', 'Ö'=>'&Ouml;', 'Ã˜'=>'&Oslash;', 'Ù'=>'&Ugrave;', 'Ú'=>'&Uacute;',
            'Û'=>'&Ucirc;', 'Ü'=>'&Uuml;', 'Ã�?'=>'&y', 'Ãž'=>'B', 'ÃŸ'=>'Ss','à'=>'&agrave;', 'á'=>'&aacute;', 'â'=>'&acirc;', 'ã'=>'&atilde;', 'ä'=>'&auml;',
            'Ã¥'=>'a', 'Ã¦'=>'a', 'ç'=>'&ccedil;', 'è'=>'&egrave;', 'é'=>'&eacute;', 'ê'=>'&ecirc;', 'ë'=>'&euml;', 'ì'=>'&igrave;', 'í'=>'&iacute;', 'î'=>'&icirc;',
            'Ã¯'=>'i', 'Ã°'=>'o', 'ñ'=>'&ntilde;', 'ò'=>'&ograve;', 'ó'=>'&oacute;', 'ô'=>'&ocirc;', 'õ'=>'&otilde;', 'ö'=>'&ouml;', 'Ã¸'=>'o', 'ù'=>'&ugrave;',
            'ú'=>'&uacute;', 'û'=>'&ucirc;', 'Ã½'=>'y', 'Ã½'=>'y', 'Ã¾'=>'b', 'Ã¿'=>'y', 'Æ'=>'f'
                      );
            ?>
            <h4>Buscar por usu&aacute;rio:</h4>
            <select name="opcao" onchange="javascript:location.href = this.value;">
                <option value="glpiIntegracao.php?opcao=0">Todos</option>
                <?php
                while($resultados = mysql_fetch_object($consulta)){
                    $firstname = strtr($resultados->firstname, $characteres);
                    $id = $resultados->id;
                    echo "\t<option value=\"glpiIntegracao.php?opcao=".$id."\">".$firstname."</option>";
                }
                ?>
            </select>
            <?php
            /*IF closedate IS NULL THEN
             SET prioridade = 1;
            ELSE THEN
             SET prioridade = 2;*/
            $query = isset($_GET['opcao']) && $_GET['opcao'] != 0? 
            
            "SELECT t.id, t.name AS ticketName, t.date AS creationDate, t.date_mod, t.status, t.content, t.status, u.name AS userName,
            IF( t.status = 'new' OR t.status = 'assign', 1, 2 ) prioridade
            FROM glpi_tickets_users tu, glpi_tickets t, glpi_users u
            WHERE tu.tickets_id = t.id AND tu.users_id = u.id AND u.id =".$_GET['opcao']."
            ORDER BY prioridade ASC , t.date_mod DESC LIMIT 30"
             : "SELECT t.id, t.name AS ticketName, t.date AS creationDate, t.date_mod, t.status, t.content, t.status, u.name AS userName,
                IF( t.status = 'new' OR t.status = 'assign', 1, 2 ) prioridade
                FROM glpi_tickets_users tu, glpi_tickets t, glpi_users u
                WHERE tu.tickets_id = t.id AND tu.users_id = u.id
                ORDER BY prioridade ASC , t.date_mod DESC LIMIT 30";

            $resultado = mysql_query($query, $link);
            mysql_close($link);

            $dataAtual = date("Y/m/d");

            if($resultado != false){				
                while($processos = mysql_fetch_object($resultado)){
                    //pegar tudo que retorna da consulta
                    $ticketName = $processos->ticketName;
                    $content = $processos->content;
                    $date = $processos->creationDate;
                    $dateMod = $processos->date_mod;
                    $userName = $processos->userName;
                    $ticketId = $processos->id;
                    $status = $processos->status;
                    /*$dataFinal = $lista->dataFinal;
                    //chama a função para subtrair datas passando a data final - data atual
                    //$dias = subData($dataAtual,$dataFinal);

                    //imprime na cor definida*/
                    /*$diferenca = diferencaData($dateMod, date());
                    if($diferenca == "true"){
                        echo "<tr class=\"red\">";
                    }else if($diferenca2 == "true" ){
                        echo "<tr class=\"yellow\">";
                    }else {
                        echo "<tr class=\"blue\">";
                    }*/
                    echo "<td>".strtr($ticketName, $characteres)."</td>
                        <td>".strtr($content, $characteres)."</td>
                        <td>".$date."</td>
                        <td>".$dateMod."</td>
                        <td>".$userName."</td>
                        <td>".traduzStatus($status)."</td>
                        <td><a href=\"http://sefad.pmo.local/glpi/front/ticket.form.php?id=".$ticketId."\"><img src=\"images/user_edit.png\" alt=\"\" title=\"\" border=\"0\" /></a></td></tr>";


                }//fim while
            }else{
                echo "
                    <tr>
                      <td>erro na conex&atilde;o com o banco glpi</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>";

            }
          ?>
          
        </table>
        <div class="pagination"></div>
        
      </div>
      <!-- end of right content--> 
    <div class="clear"></div>
  </div>
  <!--end of main content-->
  
  <div class="footer">
    <div class="left_footer">PAINEL DE ADMINISTRA&Ccedil;&Atilde;O | Desenvolvido pela Coord. Info. <a href="http://informatica.olinda.pe.gov.br" target="_blank">SEFAD</a></div>
    <a href="http://sefad.olinda.pe.gov.br" target="_blank">
    <div class="right_footer"></div>
    </a> </div>
</div>
</body>
</html>