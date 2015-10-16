 <?php 
include 'php/conexao.php';
if(isset ($_REQUEST['BtAcessar'])) {
    $login = $_REQUEST['TxtNome'];
    $senha = $_REQUEST['TxtSenha'];
    
    if(isset($_REQUEST['TxtNome']) && isset($_REQUEST['TxtSenha'])){
        echo "<h4>Nome e senha não são vazios</h4>";
    }
    $achou = true;
    $link = conexaoGLPI();
    /*para se conectar com o banco do GLPI
    $link = mysql_connect('localhost', 'root', 'B@nc0NEW', true);
    if (!$link) {
        die('Could not connect: '.mysql_error());
    }else {
    }

    $base2 = mysql_select_db('sefad_glpi', $link) or die ("could not open db" . mysql_error());*/
    
    
    //algoritmo SHA1 do mysql ou php?
    $query = "SELECT id FROM glpi_users WHERE name = '".$login."' AND password = SHA1('".$senha."')";
    $consulta = mysql_query($query, $link);
    while($resultado = mysql_fetch_object($consulta)){
        $id = $resultado->id;
    }
    
    if (mysql_num_rows($consulta) == 0) {
        $achou = false;
        mysql_close($link);
    } else {
        $link = conexaoInfoweb();
        $query = "INSERT IGNORE INTO usuario SET `idUsuario`= '".$id."', `nomeUsuario` = '".$login."', `login` = '".$login."', `senha` = SHA1('".$senha."'), `administrador` = '0'";
        $resultado = mysql_query($query);
        if(!$resultado){echo "<h4>Fai&ocirc; aqui!</h4></br>";}
        else{echo "<h4>Passou.</h4></br>";}
        
        //atualiza o último acesso
        $sql = "UPDATE usuario SET ultimoAcesso = CURDATE() WHERE idUsuario = ".$id;
        $query = mysql_query($sql) or die (mysql_error());
        
        //inicia sessão
        session_start();
        $_SESSION['login'] = $_REQUEST['TxtNome'];
        $_SESSION['id'] = $id;
        mysql_close($link);
        header("Location:index.php");
        
        /*
        //verificar se o registro já existe no banco do infoweb gerenciamento
         * //se não, fazer o registro na tabela usuários
         * $query = "SELECT firstname FROM glpi_users WHERE login = ".$login;
         * $resultado = mysql_query($query);
         * $nome = mysql_result($resultado);
         * 
         * $query = "SELECT idUsuario FROM usuarios WHERE login = ".$login;
         * $resultado = mysql_query($query);
         * $ides = mysql_num_rows($resultado);
         * 
         * if($ides == 0){
         *  //salvar no banco
         *  $query = "INSERT INTO usuarios (nomeUsuario, login) VALUES($nome, $login)";
         *  mysql_query($query);
         * }
         */
        exit;
    }
}
//---------------------			*/

$link = conexaoInfoweb();
if(!$achou){
    $sql ="SELECT idUsuario FROM usuario WHERE login ='".$login."' AND senha = '".sha1($senha)."'";
    $query = mysql_query($sql) or die (mysql_error());

    while($usuario = mysql_fetch_object($query)){
        $id = $usuario->idUsuario;
    }

    $qtda = mysql_num_rows($query);
    if($qtda == 0){
        header("Location:erro.php");
    }else{
        //atualiza o último acesso
        $sql = "UPDATE usuario SET ultimoAcesso = CURDATE() WHERE idUsuario =".$id;
        $query = mysql_query($sql) or die (mysql_error());
        
        session_start();
        $_SESSION['login'] = $_REQUEST['TxtNome'];
        $_SESSION['id'] = $id;
        header("Location:index.php");
    }
}
?>