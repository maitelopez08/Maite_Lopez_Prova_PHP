<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO 
//SUPONDO QUE O PERFIL 1 SEJA O ADMINISTRADOR

if($_SESSION['perfil']!=1){
    echo "Acesso Negado!";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash ($_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    $sql = "INSERT INTO usuario (nome,email,senha,id_perfil) VALUES (:nome, :email, :senha, :id_perfil)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id_perfil', $id_perfil);

    if($stmt->execute()){
        echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar Usuário!');</script>";    
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Usuário</title>
  <!-- Bootstrap local -->
  <link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card shadow-sm rounded-3">
          <div class="card-body">
            <h2 class="mb-4 text-center">Cadastrar Usuário</h2>

            <form action="cadastro_usuario.php" method="POST">

              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="id_perfil" class="form-label">Perfil</label>
                <select id="id_perfil" name="id_perfil" class="form-select">
                  <option value="1">Administrador</option>
                  <option value="2">Secretaria</option>
                  <option value="3">Almoxarife</option>
                  <option value="4">Cliente</option>
                </select>
              </div>

            <!-- Botones uno debajo del otro y de tamaño intermedio -->
                <div class="d-grid gap-2">
                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                <button type="reset" class="btn btn-outline-danger">Cancelar</button>
                <a href="principal.php" class="btn btn-outline-dark">Voltar</a>
                </div>


          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS local -->
  <script src="bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
