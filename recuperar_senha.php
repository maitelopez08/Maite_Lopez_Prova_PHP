<?php
session_start();
require_once 'conexao.php';
require_once 'funcoes_email.php'; //ARQUIVO COM AS FUNÇOES QUE GERAM A SENHA E SIMULAM O ENVIO

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $email = $_POST['email'];

    //VERIFICA SE O EMAIL EXISTE NO BANCO DE DADOS
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario){
        //GERA UMA SENHA TEMPORARIA E ALEATORIA
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria,PASSWORD_DEFAULT);

        //ATUALIZA A SENHA DO USUARIO NO BANCO
        $sql = "UPDATE usuario SET senha = :senha,senha_temporaria = TRUE WHERE
        email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha',$senha_hash);
        $stmt->bindParam(':email',$email);
        $stmt->execute();

        //SIMULA O ENVIO DO EMAIL (GRAVA EM TXT)
        simularEnvioEmail($email,$senha_temporaria);
        echo "<script>
    alert('Uma senha temporária foi gerada e enviada (simulação). Verifique o arquivo emails_simulados.txt');window.location.href='index.php';</script>";

    }else{
        echo "<script>alert('Email não encontrado!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar Senha</title>
<link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4 text-primary">Recuperar Senha</h3>

    <form action="recuperar_senha.php" method="POST">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
            <label for="email">E-mail cadastrado</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">Enviar Senha Temporária</button>
    </form>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">Voltar ao Login</a>
    </div>
</div>
</body>
</html>