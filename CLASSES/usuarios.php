<?php
class usuarios
{
    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha){
        global $pdo;
        global $msgErro;

        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }

    public function cadastrar($nome, $telefone, $email, $senha){
        global $pdo;
        // Verificação se o email já existe
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false; // Email já cadastrado
        } else {
            // Cadastro com senha criptografada
            $sql = $pdo->prepare("INSERT INTO usuarios(nome, telefone, email, senha) VALUES(:n, :t, :e, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", password_hash($senha, PASSWORD_DEFAULT));
            $sql->execute();
            return true;
        }
    }

    public function logar($email, $senha){
        global $pdo;
    
        // Verificação do email
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            // Verificar senha
            $info = $sql->fetch();
            if (password_verify($senha, $info['senha'])) {
                // Iniciar sessão
                session_start();
                $_SESSION['id_usuario'] = $info['id_usuario'];
                return true;
            } else {
                return false; // Senha incorreta
            }
        } else {
            return false; // Email não encontrado
        }
    }
}
