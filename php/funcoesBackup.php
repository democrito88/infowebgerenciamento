<?php
	//include conexÃ£o
	include 'conexao.php';
	
	function atualizaStatus(){
		$query = "UPDATE acao SET status='3' WHERE (DATEDIFF(dataFinal, CURDATE()) < 1) AND (status = '1' OR status = '2')";
		mysql_query($query);
		}
	
	function selectArquivos($idAcao){
		$query  = "SELECT * FROM arquivo WHERE acao_idAcao = ".$idAcao;
		$resultado = mysql_query($query);
		
		//se houver arquivos associados à ação
		if($resultado != false){
			if(mysql_num_rows($resultado) > 1){
				$retorno =  "<form name='form' \"><select name='arquivo' form='form'>";
				while($arquivo = mysql_fetch_object($resultado)){
					$retorno = $retorno."<option onclick=\"baixar(".$arquivo->idArquivo.")\">".$arquivo->nomeArquivo."</option>";
				}
				$retorno = $retorno."</select></form>";
			}else if(mysql_num_rows($resultado) == 1){
				while($arquivo = mysql_fetch_object($resultado)){
					$retorno = "<a  name=\"".$arquivo->nomeArquivo."\" href=\"baixar_arquivo.php?idArquivo=".$arquivo->idArquivo."\">".$arquivo->nomeArquivo."</a>";
				}
				}else{
					$retorno = "Não possui";
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
			case '5': return "Concluído";
			default: return "Não definido";
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
		};

			
	//funÃ§Ã£o para subtrair data
	function subData($data1, $data2){
		 
		// Usa a funÃ§Ã£o strtotime() e pega o timestamp das duas datas:
		$time_inicial = strtotime($data1);
		$time_final = strtotime($data2);
		 
		// Calcula a diferenÃ§a de segundos entre as duas datas:
		$diferenca = $time_final - $time_inicial; 
		 
		// Calcula a diferenÃ§a de dias
		$dias = (int)floor( $diferenca / (60 * 60 * 24)); 
		return $dias;
		 
	}
	//Função para criar o menu
	function creatMenu(){
		
		//função para criar os menus e sub menus com as cores indicadas
		//cor 1 = vermelho
		//cor 2 = amarelo
		//cor 3 = azul
		$dataAtual = date("Y/m/d");
		$pro = mysql_query("SELECT * FROM projeto WHERE status = 1 OR status = 2 OR status = 3 OR status IS NULL");
		$numero = mysql_num_rows($pro);
		
		while($res = mysql_fetch_object($pro)){			
			$idProjeto = $res->idProjeto;
			$nomeProjeto = $res->nomeProjeto;
			
			$sub = mysql_query("select * from subprojeto where Projeto_idProjeto = ".$idProjeto);
		 	while($subProjetos = mysql_fetch_object($sub)){				
				$idSubProjeto = $subProjetos->idSubProjeto;
				$nomeSub = $subProjetos->nomeSubProjeto;
				$acoes = mysql_query("select * from acao where subProjeto_idSubProjeto = ".$idSubProjeto);
				
				$cor = 0;
				$corP = 3;//valores iniciais das cores
				
				while($lista = mysql_fetch_object($acoes)){					
					$dataFinal = $lista->dataFinal;
					//chama a função para subtrair datas passando a data final - data atual
					$dias = subData($dataAtual,$dataFinal);
					if($dias>=0 && $dias<=10){
						$cor = 1;
						$projeto = $idProjeto;
					}else if($dias>10 && $dias<=20){
						$cor = 2;
						$projeto = $idProjeto;
					}else if($dias>20){
						$cor = 3;
						$projeto = $idProjeto;
					}
					
					if($cor < $corP){
						$corP = $cor;
					}
					
				}//fim while acao
			}//fim while subProjeto
				if(mysql_affected_rows() != 0){//se houver alguma ação cadastrada
					if($corP == 3){ 
						echo "<a class='menuitem submenuheader' href=''>".$res->nomeProjeto."</a>";		
					}else if($corP == 2){
						echo "<a class='menuitem_yellow submenuheader' href=''>".$res->nomeProjeto."</a>";		
					}else{
						echo "<a class='menuitem_red submenuheader' href=''>".$res->nomeProjeto."</a>";
					} 
					echo "<div class='submenu'><ul>";
					
					$sub = mysql_query("select * from subprojeto where Projeto_idProjeto = ".$idProjeto);
					$cont = 0;
					while($subProjetos = mysql_fetch_object($sub)){
						$idSubProjeto = $subProjetos->idSubProjeto;
						$nomeSub = $subProjetos->nomeSubProjeto;
						
						if($cor != 0){
							echo "<li><a href=\"acao.php?opcao=0&idSub=".$idSubProjeto."\">".$nomeSub."</li>";
						}
					}
					if($cor != 0){
					echo "<a class='menuitem_green' href='cadastrarSubProjeto.php?idProjeto=".$idProjeto."'>Add Sub Projeto</a></ul></div>";
					}	
				
					}else{//se não houver ação cadastrada
						echo "<a class='menuitem submenuheader' href=''>".$res->nomeProjeto."</a>";		
						echo "<div class='submenu'><ul>";
						$sub = mysql_query("select * from subprojeto where Projeto_idProjeto = ".$idProjeto);
						
						while($subProjetos = mysql_fetch_object($sub)){
							$idSubProjeto = $subProjetos->idSubProjeto;
							$nomeSub = $subProjetos->nomeSubProjeto;
							echo "<li><a href=\"acao.php?idSub=".$idSubProjeto."\">".$nomeSub."</li>";
						}
						
						echo "<a class='menuitem_green' href='cadastrarSubProjeto.php?idProjeto=".$idProjeto."'>Adicionar Subprojeto</a></ul></div>";
				
				}
				
				
		}//fim while projeto
			
	}//fim creatMenu

function formataData($data){
	$arrayData = array();
	$pos = 0;
	$posc = 0;
	
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
?>