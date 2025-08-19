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
  <link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="validacao_usuario.js"></script>
</head>
<body class="bg-light">
<?php include 'menu.php'; ?>

  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-6">

      <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white text-center">
          <h2 class="mb-0">Cadastrar Usuário</h2>
        </div>
        <div class="card-body">

          <form action="cadastro_usuario.php" method="POST" onsubmit="return validarUsuario()">

            <div class="form-floating mb-3">
              <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome">
              <label for="nome">Nome</label>
            </div>

            <div class="form-floating mb-3">
              <input type="email" id="email" name="email" class="form-control" placeholder="Email">
              <label for="email">Email</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
              <label for="senha">Senha</label>
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

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Salvar</button>
              <button type="reset" class="btn btn-secondary">Cancelar</button>
              <a href="principal.php" class="btn btn-dark">Voltar</a>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>  
</body>
</html>