<?php
session_start();
require_once 'conexao.php';

//GARANTE QUE O USUARIO ESTEJA LOGADO
if (!isset($_SESSION['id_usuario'])){
    echo "<script>alert('Acesso Negado');window.location.href='index.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_usuario = $_SESSION['id_usuario'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if($nova_senha !== $confirmar_senha){
        echo "<script>alert('As senhas não coincidem!')</script>";
    } elseif(strlen($nova_senha)<8){
        echo "<script>alert('A senha deve ter pelo menos 8 caracteres!');</script>";

    }elseif($nova_senha === "temp123"){
        echo "<script>alert('Escolha uma senha diferente de temporaria!');</script>";
    }else{
        $senha_hash = password_hash($nova_senha,PASSWORD_DEFAULT);
        //SITUALIZA A SENHA E REMOVE O STATUS DE TEMPORARIA
        $sql = "UPDATE usuario SET senha= :senha,senha_temporaria = FALSE WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id',$id_usuario);

        if($stmt->execute()){
            session_destroy(); //FINALIZA A SESSAO
            echo "<script>alert('Senha alterada com sucesso! Faça login novamente');window.location.href='index.php';</script>";
        }else{
            echo "<script>alert('Erro ao alterar a senha!');window.location.href='index.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alterar Senha</title>
<link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4 text-primary">Alterar Senha</h3>

    <p class="text-center mb-3">Olá, <strong><?php echo $_SESSION['usuario'];?></strong>. Digite sua nova senha abaixo:</p>

    <form action="alterar_senha.php" method="POST">
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Nova senha" required>
            <label for="nova_senha">Nova Senha</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Confirmar nova senha" required>
            <label for="confirmar_senha">Confirmar Nova Senha</label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="mostrarSenha" onclick="mostrarSenha()">
            <label class="form-check-label" for="mostrarSenha">Mostrar senha</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">Salvar Nova Senha</button>
    </form>
</div>
<script>
function mostrarSenha(){
    var senha1 = document.getElementById("nova_senha");
    var senha2 = document.getElementById("confirmar_senha");
    var tipo = senha1.type === "password" ? "text" : "password";
    senha1.type = tipo;
    senha2.type = tipo;
}
</body>
</html>