<?php
session_start();
require 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO DE adm
if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR USUARIOS
$usuarios = [];

//BUSCA TODOS OS USUARIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM id FOR PASSADO VIA GET EXCLUI O USUARIO 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    //EXCLUI O USUARIO DO BANCO DE DADOS 
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_usuario,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuario excluido com Succeso!');window.location.href='excluir_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir o usuario');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excluir Usuário</title>
  <link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
<?php include 'menu.php'; ?>
  <div class="d-flex align-items-center justify-content-center vh-10">
    <div class="col-md-8">
      <div class="card shadow-sm rounded-3">
        <div class="card-header bg-danger text-white text-center">
          <h2 class="mb-0">Excluir Usuário</h2>
        </div>
        <div class="card-body">

          <?php if(!empty($usuarios)): ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($usuarios as $usuario): ?>
                  <tr>
                    <td><?= htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?= htmlspecialchars($usuario['nome'])?></td>
                    <td><?= htmlspecialchars($usuario['email'])?></td>
                    <td>
                      <?php
                        switch($usuario['id_perfil']){
                          case 1: echo "Administrador"; break;
                          case 2: echo "Secretária"; break;
                          case 3: echo "Almoxarife"; break;
                          case 4: echo "Cliente"; break;
                          default: echo "Desconhecido";
                        }
                      ?>
                    </td>
                    <td class="text-center">
                      <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"
                         class="btn btn-sm btn-outline-danger"
                         onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                        Excluir
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p class="text-center text-muted">Nenhum usuário encontrado</p>
          <?php endif; ?>

          <div class="d-grid gap-2 mt-3">
            <a href="principal.php" class="btn btn-dark">Voltar</a>
          </div>

        </div>
      </div>

    </div>
  </div>
</body>
</html>