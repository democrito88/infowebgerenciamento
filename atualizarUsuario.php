<?PHP
include 'php/funcoes.php';

conexaoInfoweb();
$id = $_GET['idUsuario'];
$admin = $_GET['admin'];
$nomeUsuario = $_POST['nomeUsuario'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$email = $_POST['email'];
if(isset($_POST['administrador'])){$administrador = $_POST['administrador'];}

//se a senha for alterada
if($senha != ""){
        $query = "UPDATE usuario SET nomeUsuario='".$nomeUsuario."', login='".$login."', senha='".sha1($senha)."', email='".$email."', administrador='".$administrador."' WHERE idUsuario = ".$id;
}else{
        $query = "UPDATE usuario SET nomeUsuario='".$nomeUsuario."', login='".$login."', email='".$email."', administrador='".$administrador."' WHERE idUsuario = ".$id;
}

$sub = mysql_query($query);

header( $admin == 1 ? 'Location: /infowebgerenciamento/usuarios.php' : 'Location: /infowebgerenciamento/index.php' ) ;
//header( $admin == 1 ? 'Location: http://sefad.pmo.local/infowebgerenciamento/usuarios.php' : 'Location: http://sefad.pmo.local/infowebgerenciamento/index.php' ) ;
?>