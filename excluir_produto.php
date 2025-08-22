<?php
session_start();
require 'conexao.php';
require_once 'menu.php';

//VERIFICA SE O USUARIO TEM PRMISSAO DE ADM, SECRETARIA OU ALMOXARIFE
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR PRODUTOS
$produtos = [];

//BUSCA TODOS OS PRODUTOS CADASTRADOS ORDENADOS POR ID DE PRODUTO
$sql = "SELECT * FROM produto ORDER BY id_produto ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM id FOR PASSADO VIA GET EXCLUI O PRODUTO 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_produto = $_GET['id'];

    //EXCLUI O PRODUTO DO BANCO DE DADOS 
    $sql = "DELETE FROM produto WHERE id_produto = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_produto,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Produto excluido com Succeso!');window.location.href='excluir_produto.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir o Produto');window.location.href='excluir_produto.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Excluir Produto</h2>
    <?php if(!empty($produtos)): ?>
        <table class="tabela-excluir">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>

        <?php foreach($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['id_produto'])?></td>
                <td><?= htmlspecialchars($produto['nome_prod'])?></td>
                <td><?= htmlspecialchars($produto['descricao'])?></td>
                <td><?= htmlspecialchars($produto['qtde'])?></td>
                <td><?= htmlspecialchars($produto['valor_unit'])?></td>
                <td>
                    <a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>"onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table> 
        <?php else: ?>
            <p>Nenhum produto encontrado</p>
        <?php endif; ?>
        <div  class="voltar">
        <a class="link" href="principal.php">Voltar</a>
        </div>
    <br><br><br>
    <address>
        <center> Maite López / Estudante / Tecnico em Desenvolvimento de Sistemas</center>
    </address>
</body>
</html>