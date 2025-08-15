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
$sql = "SELECT * FROM usuarios ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM id FOR PASSADO VIA GET EXCLUI O USUARIO 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    //EXCLUI O USUARIO DO BANCO DE DADOS 
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('id',$id_usuario,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuario excluido com Succeso!');window.location.href='excluir_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir o usuario');</script>";
    }
}
?>