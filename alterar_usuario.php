<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PRMISSAO DE ADM
if($_SESSION['perfil'] !=1){
    echo "<script>alert('Ácesso negado!');window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEIS
$usuario = null;

if($_SERVER["REQUEST_METHOD"]== "POST"){
    if(!empty($_POST['busca_usuario'])){
        $busca = trim($_POST['busca_usuario']);

        //VERIFICA SE A BUSCA É UM NÚMERO (id) OU UM nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
        }
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //SE O USUARIO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
        if(!$usuario){
            echo "<script>alert('Usuario não encontrado!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Usuário</title>
  <link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
  <!--CERTIFIQUE-SE DE QUE O SCRIPT ESTÁ SENDO CARREGADO CORRETAMENTE -->
  <script src="scripts.js"></script>
</head>
<body class="bg-light">

  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-8">

      <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white text-center">
          <h2 class="mb-0">Alterar Usuário</h2>
        </div>
        <div class="card-body">


          <form action="alterar_usuario.php" method="POST" class="mb-4">
            <div class="form-floating mb-3">
              <input type="text" id="busca_usuario" name="busca_usuario" class="form-control" placeholder="Digite o id ou nome" required onkeyup="buscarSugestoes()">
              <label for="busca_usuario">Digite o ID ou nome do usuário</label>
            </div>

        <!-- DIV PARA EXIBIR SUGESTOES DE USUARIOS -->
            <div id="sugestoes" class="mb-3"></div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Buscar</button>
              <a href="principal.php" class="btn btn-dark">Voltar</a>
            </div>
          </form>

          <?php if($usuario): ?>
          <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario']);?>">

            <div class="form-floating mb-3">
              <input type="text" id="nome" name="nome" class="form-control" value="<?=htmlspecialchars($usuario['nome']);?>" placeholder="Nome" required>
              <label for="nome">Nome</label>
            </div>

            <div class="form-floating mb-3">
              <input type="email" id="email" name="email" class="form-control" value="<?=htmlspecialchars($usuario['email']);?>" placeholder="Email" required>
              <label for="email">Email</label>
            </div>

            <div class="mb-3">
              <label for="id_perfil" class="form-label">Perfil</label>
              <select id="id_perfil" name="id_perfil" class="form-select">
                <option value="1" <?=$usuario['id_perfil'] == 1 ? 'selected':''?>>Administrador</option>
                <option value="2" <?=$usuario['id_perfil'] == 2 ? 'selected':''?>>Secretária</option>
                <option value="3" <?=$usuario['id_perfil'] == 3 ? 'selected':''?>>Almoxarife</option>
                <option value="4" <?=$usuario['id_perfil'] == 4 ? 'selected':''?>>Cliente</option>
              </select>
            </div>
        
            <!-- SE O USUARIO LOGADO FOR ADM, EXIBIR OPÇAO DE ALTERAR SENHA -->

            <?php if($_SESSION['perfil'] == 1): ?>
            <div class="form-floating mb-3">
              <input type="password" id="nova_senha" name="nova_senha" class="form-control" placeholder="Nova senha">
              <label for="nova_senha">Nova Senha</label>
            </div>
            <?php endif; ?>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Alterar</button>
              <button type="reset" class="btn btn-secondary">Cancelar</button>
            </div>
          </form>
          <?php endif; ?>

        </div>
      </div>

    </div>
  </div>
</body>
</html>