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
            $stmt->bindParam(':busca_nome',"%$busca%",PDO::PARAM_STR);
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
    <title>Alterar Usuario</title>
    <link rel="stylesheet" href="styles.css">
<!--CERTIFIQUE-SE DE QUE O SCRIPT ESTÁ SENDO CARREGADO CORRETAMENTE -->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Usuário</h2>

    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o id ou nome do usuario</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
       
<!-- DIV PARA EXIBIR SUGESTOES DE USUARIOS -->
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
    </form>
<?php if($usuario):?>
    <form action="prcessa_alteracao_usuario.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">

        <label for="nome">Nome:</label>
        <input type="hidden" name="" value="<?=htmlspecialchars($usuario['id_usuario'])?>">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>">

        <label for="nome">Nome:</label>
</body>
</html>