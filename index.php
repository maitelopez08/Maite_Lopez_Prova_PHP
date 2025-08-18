<?php
session_start();
require_once 'conexao.php';

if($_SERVER['REQUEST_METHOD']== "POST"){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $usuario = $stmt->fetch (PDO::FETCH_ASSOC);
    
    if($usuario && password_verify($senha,$usuario['senha'])){
        //LOGIN BEM SUCEDIDO DEFINE VARIAVEIS DE SESSAO
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['id_perfil'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        //VERIFICA SE A SENHA É TEMPORARIA
        if($usuario['senha_temporaria']){
            //REDIRECIONA PARA A TROCA DE SENHA
            header("Location: alterar_senha.php");
            exit();
        } else{
            //REDIRECIONA PARA A PAGINA PRINCIPAL
            header("Location: principal.php");
            exit();
        }
    } else{
        //LOGIN INVALIDO
        echo "<script>alert('E-mail ou senha incorretos');window.location.href='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4 text-primary">Login</h3>

    <form action="index.php" method="POST">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
            <label for="email">E-mail</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
            <label for="senha">Senha</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="recuperar_senha.php" class="text-decoration-none">Esqueci a minha senha</a>
    </div>
</div>
</body>
</html>

