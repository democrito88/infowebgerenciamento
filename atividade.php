<?php
include 'php/funcoes.php';
include 'testelogin.php';

//recebe o id do sub processo
if(isset($_GET['idProcesso'])){
    $idProcesso = $_GET['idProcesso'];
}else{$idProcesso = 1;}

//atualiza o status das ações colocando a marcação 'atrasado' (status = 3), se necessário
//atualizaStatus();
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
		document.forms.submit();
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
    <div class="right_header"><?php $administrador = menuUsuario();?>
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
        <div class="sidebar_box">
          <!-- <div class="sidebar_box_top"></div>
           <div class="sidebar_box_content">
            <h3>Gerenciamento</h3>
            <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
            <p>Crie processos, sub processos e ações com responsáveis e datas de início e fim de cada ação. Fique ligado! Não deixe sua árvore com galhos vermelhos e improdutivos.</p>
          </div>
          <div class="sidebar_box_bottom"></div>
        </div> -->
      </div> <!--end of left content-->
      
    </div>
    <!--end of center content -->
    <div class="right_content">
        <h2 id="atividade">Atividades</h2>
        <div>
            <form id="selecionar" action="<?php echo "atividade.php"; ?>">
                <h4>Buscar atividades:</h4>
                <select name="opcao" form="selecionar">
                    <option value="0" selected="selected">Em aberto</option>
                    <option value="1">Todos</option>
                    <option value="2">Fechado</option>
                </select>
                <input type="submit" onclick="validateForm(this.form)" value="Buscar" />
                <input name="idProcesso" value="<?php echo $idProcesso;?>" style="visibility:hidden"/><!--Não aparecerá. Apenas para salvar o id.-->
            </form>
        </div>
        <table id="rounded-corner" summary="2007 Major IT Companies' Profit" style="width:870px">
          <thead>
            <tr>
              <th scope="col" class="rounded-company">Nome</th>
              <th scope="col" class="rounded-company">Situa&ccedil;&atilde;o</th>
              <th scope="col" class="rounded">Data Inicial</th>
              <th scope="col" class="rounded">Data Final</th>
              <th scope="col" class="rounded">Status</th>
              <th scope="col" class="rounded">Arquivos</th>
              <th scope="col" class="rounded">Atribu&iacute;do para</th>
              <th scope="col" class="rounded">Editar</th>
              <th scope="col" class="rounded-q4">Remover</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
             <?php	
                //seleciona as acoes e seus respectivos arquivos
                if(isset($_GET['opcao']) && $_GET['opcao'] == 2){
                    $query = "SELECT a.*, u.nomeUsuario,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.1 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.2 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca2
                    FROM atividade a INNER JOIN usuario u WHERE (a.status = '4' OR a.status = '5') AND (a.processo_idProcesso = '".$idProcesso."') AND (u.idUsuario = a.usuario_idUsuario)";
                }
                else if(isset($_GET['opcao']) && $_GET['opcao'] == 1){
                    $query = "SELECT a.*, u.nomeUsuario,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.1 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.2 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca2
                    FROM atividade a INNER JOIN usuario u WHERE a.processo_idProcesso = ".$idProcesso." AND u.idUsuario = a.usuario_idUsuario";
                }
                else{
                    $query = "SELECT a.*, u.nomeUsuario,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.1 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca,
                    IF( DATEDIFF( a.dataFinal, CURDATE( ) ) < ( 0.2 * DATEDIFF( a.dataFinal, a.dataInicial ) ) ,'true' , 'false' ) diferenca2
                    FROM atividade a INNER JOIN usuario u WHERE (a.status = '1' OR a.status = '2' OR a.status = '3') AND (a.processo_idProcesso = '".$idProcesso."') AND (u.idUsuario = a.usuario_idUsuario)";
                }

                $resultados = mysql_query("SELECT nomeProcesso FROM processo WHERE idProcesso = ".$idProcesso);
                while($processos = mysql_fetch_object($resultados)){
                    $nomeProcesso = $processos->nomeProcesso;
                }
            ?>
              <td colspan="8" class="rounded-foot-left"><em>Estas são as atividades relacionadas em<?php echo " ".$nomeProcesso;?>.</em></td>
              <td class="rounded-foot-right">&nbsp;</td>
            </tr>
          </tfoot>
          <tbody>
        <?php
            $dataAtual = date("Y/m/d");
            $atividades = mysql_query($query);

            if($atividades != false){				
                while($lista = mysql_fetch_object($atividades)){
                    $diferenca = $lista->diferenca;
                    $diferenca2 = $lista->diferenca2;
                    //$dataFinal = $lista->dataFinal;
                    //chama a função para subtrair datas passando a data final - data atual
                    //$dias = subData($dataAtual,$dataFinal);

                    //imprime na cor definida
                    if($diferenca == "true"){
                        echo "<tr class=\"red\">";
                    }else if($diferenca2 == "true" ){
                        echo "<tr class=\"yellow\">";
                    }else {
                        echo "<tr class=\"blue\">";
                    }
                    echo "<td>".$lista->nomeAtividade."</td>
                        <td>".$lista->situacao."</td>
                        <td>".date_format(date_create($lista->dataInicial), "d-m-Y")."</td>
                        <td>".date_format(date_create($lista->dataFinal), "d-m-Y")."</td>
                        <td>".status($lista->status)."</td>
                        <td>".selectArquivos($lista->idAtividade)."</td>
                        <td>".$lista->nomeUsuario."</td>
                        <td><a href=\"editarAtividade.php?idAtividade=".$lista->idAtividade."\"><img src=\"images/user_edit.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                        <td>".($administrador == 1? "<a href=\"removerAtividade.php?idAtividade=".$lista->idAtividade."\" class=\"ask\"><img src=\"images/trash.png\" alt=\"\" title=\"\" border=\"0\" /></a>" : "<img src=\"images/trash2.png\">")."</td>
                        </tr>
                        <tr><td colspan='9' class='detalhe'><a href='' onclick='window.open(\"logAtividade.php?idProcesso=".$idProcesso."&idAtividade=".$lista->idAtividade."\",\"teste\",\"width=800,height=550\");'>Detalhe</a></td></tr>";
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
                      <td><a href=\"#\"><img src=\"images/user_edit.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                      <td><a href=\"#\" class=\"ask\"><img src=\"images/trash.png\" alt=\"\" title=\"\" border=\"0\" /></a></td>
                    </tr>";
            }
        ?>
          </tbody>
        </table>
        <a href="cadastrarAtividade.php?idProcesso=<?php echo $_GET['idProcesso'];?>" class="bt_green"><span class="bt_green_lft"></span><strong>Adicionar Nova Atividade neste Processo</strong><span class="bt_green_r"></span></a>
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