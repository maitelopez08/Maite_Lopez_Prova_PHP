<?php
session_start();
require_once 'conexao.php';
require_once 'menu.php';

//VERIFICA SE O USUARIO TEM PRMISSAO DE ADM
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=3 ){
    echo "<script>alert('Ácesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEIS
$produto = null;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(!empty($_POST['busca_produto'])){
        $busca = trim($_POST['busca_produto']);

        //VERIFICA SE A BUSCA É UM NÚMERO (id) OU UM nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM produto WHERE id_produto = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_produto";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_produto',"%$busca%",PDO::PARAM_STR);
        }
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //SE O PRODUTO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
        if(!$produto){
            echo "<script>alert('Produto não encontrado!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="styles.css">
<!--CERTIFIQUE-SE DE QUE O SCRIPT ESTÁ SENDO CARREGADO CORRETAMENTE -->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Produto</h2>

    <form action="alterar_produto.php" method="POST">
        <label for="busca_produto">Digite o id ou nome do produto</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">
        <button type="submit">Buscar</button>
    </form>
<?php if($produto):?>
    <form action="processa_alteracao_produto.php" method="POST" onsubmit="return validarAlteracao()">
        <input type="hidden" name="id_produto" value="<?=htmlspecialchars($produto['id_produto']);?>">

        <label for="nome_prod">Nome:</label>
        <input type="text" id="nome_prod" name="nome_prod" value="<?=htmlspecialchars($produto['nome_prod']);?>">

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" value="<?=htmlspecialchars($produto['descricao']);?>"></textarea>

        <label for="qtde">Quantidade:</label>
        <input type="number" id="qtde" name="qtde" value="<?=htmlspecialchars($produto['qtde']);?>">

        <label for="valor_unit">Valor:</label>
        <input type="number" id="valor_unit" name="valor_unit" value="<?=htmlspecialchars($produto['valor_unit']);?>">

        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
        <div  class="voltar">
        <a class="link" href="principal.php">Voltar</a>
    </div>
        </form>
    <?php endif; ?>

</body>
</html>
