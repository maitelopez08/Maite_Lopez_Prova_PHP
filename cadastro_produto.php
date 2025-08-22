<?php
session_start();
require_once 'conexao.php';
require_once 'menu.php';

//VERIFICA SE O USUARIO TEM PRMISSAO DE ADM OU ALMOXARIFE

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3){
    echo "<script>alert('Ácesso negado!'); window.location.href='principal.php';</script>";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome_prod = $_POST['nome_prod'];
    $descricao = $_POST['descricao'];
    $qtde = $_POST['qtde'];
    $valor_unit = $_POST['valor_unit'];

    $sql = "INSERT INTO produto (nome_prod,descricao,qtde,valor_unit) VALUES (:nome_prod,:descricao,:qtde,:valor_unit)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_prod', $nome_prod);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':qtde', $qtde);
    $stmt->bindParam(':valor_unit', $valor_unit);

    if($stmt->execute()){
        echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='cadastro_produto.php';</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar Produto!'); window.location.href='cadastro_produto.php';</script>";  
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
    <form action="cadastro_produto.php" method="POST" onsubmit="return validarProduto()">

    <label for="nome_prod">Nome:</label>
    <input type="text" id="nome_prod" name="nome_prod">

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"></textarea>

    <label for="qtde">Quantidade:</label>
    <input type="text" id="qtde" name="qtde">

    <label for="valor_unit">Valor:</label>
    <input type="number" id="valor_unit" name="valor_unit" step="0.01">

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    <div  class="voltar">
        <a class="link" href="principal.php">Voltar</a>
    </div>
    </form>
<script src="validacao_produto.js"></script>
<br><br><br>
<br><br><br>
    <footer>
        <center> Maite López / Estudante / Tecnico em Desenvolvimento de Sistemas</center>
</footer>    
</body>
</html>