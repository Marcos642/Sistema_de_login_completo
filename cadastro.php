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
    <div>
        <div id="Cabecalho"><a href="index.php">Login</a></>
    </div>
    <div id="corpo-form">
        <h1>Cadastro</h1>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" MAXLENGTH="50">
            <input type="text" name="telefone" placeholder="Telefone" MAXLENGTH="12">
            <input type="email" name="email" placeholder="Email" MAXLENGTH="30">
            <input type="senha" name="senha" placeholder="Senha" MAXLENGTH="16">
            <input type="senha" name="confSenha" placeholder="Confirmar Senha" MAXLENGTH="16">
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    <?php
    if(isset($_POST['nome']))
    {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
        $confSenha = addslashes($_POST['confSenha']);


        if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confSenha)){
            $user -> conectar("MCV", "localhost","root","");
            if ($user -> msgErro == ""){
                if ($senha == $confSenha){
                    if($user->cadastrar($nome, $telefone, $email, $senha)){
                    ?>
                    <div id="msg-sucesso">"Email cadastrado com sucesso. Agora é só logar"</div>
                    <?php
                    }else {
                    ?>
                    <div class="msg-erro">"Este email já foi usado"</div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="msg-erro">As senhas não são iguais</div>
                    <?php
                }
            }else {
                ?>
                <div class="msg-erro">
                    <?php echo "ERRO: " . $user -> $msgErro; ?>
                </div>
            <?php
            }
        } else {
            ?>
    <div class="msg-erro"> "Por gentileza. Preencha todos os campos." </div>
        <?php
        }
    }
    ?>
</body>
</html>
