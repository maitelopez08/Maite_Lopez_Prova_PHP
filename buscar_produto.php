<?php
session_start();
require_once 'conexao.php';
require_once 'menu.php';

//TODOS OS USUARIOS TEM PERMISSÃO PARA BUSCAR PRODUTO

if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM numero OU UM nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM produto WHERE nome_prod LIKE :busca_nome_prod ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome_prod',"%$busca%", PDO::PARAM_STR);
    }
}else{
    //BUSCA TODOS OS PRODUTOS CADASTRADOS ORDENADOS POR ID DE PRODUTO
        $sql="SELECT * FROM produto ORDER BY id_produto ASC";
        $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de Produtos</h2>    
    <form action="buscar_produto.php" method="POST">
        <label for="busca">Digite o ID ou Nome(opcional):</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>
        <?php if(!empty($produtos)):?>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor unitário</th>
                    <th>Ações</th>
                </tr>
                <?php foreach($produtos as $produto): ?>
      
                <tr>
                    <td><?=htmlspecialchars($produto['id_produto'])?></td>
                    <td><?=htmlspecialchars($produto['nome_prod'])?></td>
                    <td><?=htmlspecialchars($produto['descricao'])?></td>
                    <td><?=htmlspecialchars($produto['qtde'])?></td>
                    <td><?=htmlspecialchars($produto['valor_unit'])?></td>
                    <td>
                        <a href="alterar_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>">Alterar</a>
                        
                        <a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>"onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>              
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
    <?php else:?>
        <p>Nenhum produto encontrado.</p>
    <?php endif;?>

    <div  class="voltar">
        <a class="link" href="principal.php">Voltar</a>
    </div>
    <br><br><br>
    <footer>
        <center> Maite López / Estudante / Tecnico em Desenvolvimento de Sistemas</center>
</footer>    
</body>
</html>
