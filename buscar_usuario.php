<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PRMISSAO DE adm OU Secretaria
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2){
    echo "<script>alert('Ácesso negado!');window.location.href='principal.php'</script>";
    exit();
}

$usuario = []; //INICIALIZA A VARIAVEL PARA EVITAR ERROS

//SE O FORMULARIO FOI ENVIADO, BUSCA O USUARIO PELO ID OU NOME
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM numero OU UM nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome',"$busca%", PDO::PARAM_STR);
    }
}else{
        $sql="SELECT * FROM usuario ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buscar Usuário</title>
<link rel="stylesheet" href="bootstrap-5.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
<?php include 'menu.php'; ?>
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Lista de Usuários</h2>    


        <form action="buscar_usuario.php" method="POST" class="row g-3 mb-4">
            <div class="col-md-8">
                <input type="text" class="form-control" id="busca" name="busca" placeholder="Digite o ID ou Nome">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
            </div>
        </form>

        <?php if(!empty($usuarios)):?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Ações</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                                <td><?=htmlspecialchars($usuario['nome'])?></td>
                                <td><?=htmlspecialchars($usuario['email'])?></td>
                                <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                                <td>
                                    <a href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" 
                                       class="btn btn-warning btn-sm">Alterar</a>
                                    <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>              
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        <?php else:?>
            <div class="alert alert-warning text-center">Nenhum usuário encontrado.</div>
        <?php endif;?>

        <div class="text-center mt-3">
            <a href="principal.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
</body>
</html>
