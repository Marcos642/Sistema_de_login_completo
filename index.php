<?php
require_once 'CLASSES/usuarios.php';
$user = new usuarios();
$user->conectar("MVC", "localhost","root","");
?>

<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title> Login </title>
	<link rel="stylesheet" href="CSS/estilo.css">
</head>
<body>
	<div id="corpo-form">
	<h1>Entrar</h1>
	<form method="POST">
		<input type="email" name="email" placeholder="Email">
		<input type="text" name="senha" placeholder="Senha">
		<input type="submit" value="Acessar">
		<a href="cadastro.php"> Ainda não é inscrito?<strong>Cadastre-se</strong></a>
	</form>
	</div>
    <?php
    if(isset($_POST['email']))
    {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if (!empty($email) && !empty($senha)) {
        $user->conectar("MVC", "localhost","root","");
        if($user->msgErro == ""){
            if($user->logar($email, $senha)){
                header("location: arearestrita.php");
                die();
            } else {
                ?>
                <div class="msg-erro"> Email ou Senha não conferem </div>
            <?php
            }
        } else {
            ?>
            <div class="msg-erro">
                <?php
                echo "ERRO: " . $user -> msgErro;
                ?>
            </div>
        <?php
        }

    }else {
        ?>
        <div class="msg-erro"> Por gentileza. Preencha os dois campos </div>
    <?php
        }
    }
    ?>
</body>
</html>
