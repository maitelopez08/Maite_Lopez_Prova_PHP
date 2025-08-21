<?php
session_start();
require_once 'conexao.php';
require_once 'menu.php';

//VERIFICA SE O USUARIO TEM PERMISSAO 
//SUPONDO QUE O PERFIL 1 SEJA O ADMINISTRADOR

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3){
    echo "Acesso Negado!";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome_prod = $_POST['nome_prod'];
    $descricao = $_POST['descricao'];
    $qtde = $_POST['qtde'];
    $valor_unit = $_POST['valor_unit'];

    $sql = "INSERT INTO produto (nome_prod,descricao,qtde,valor_unit) VALUES (:nome_prod,:descricao,:qtde,valor_unit)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_prod', $nome_prod);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':qtde', $qtde);
    $stmt->bindParam(':valor_unit', $valor_unit);

    if($stmt->execute()){
        echo "<script>alert('Produto cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar Produto!');</script>";    
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar Produto</h2>
    <form action="cadastro_produto.php" method="POST" onsubmit="return validarUsuario()">

    <label for="nome_prod">nome_prod:</label>
    <input type="text" id="nome_prod" name="nome_prod">

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"></textarea>

    <label for="qtde">Quantidade:</label>
    <input type="text" id="qtde" name="qtde">

    <label for="valor_unit">Valor:</label>
    <input type="text" id="valor_unit" name="valor_unit">

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
        <div  class="voltar">
        <a class="link" href="principal.php">Voltar</a>
    </div>
    </form>
    <!-- <script src="validacao_usuario.js"></script> -->
</body>
</html>