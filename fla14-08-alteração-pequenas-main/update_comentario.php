<?php
// Inicia uma nova sessão ou retoma uma sessão existente
session_start();
// Inclui o arquivo de conexão com o banco de dados
require 'conexao.php'; 

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID e o comentário do formulário
    $id = $_POST['id'];
    $comentario = $_POST['comentario'];

    // Validação básica para garantir que o ID e o comentário não estejam vazios
    if (!empty($id) && !empty($comentario)) {
        // Prepara a consulta para atualizar o comentário na tabela 'comentarios'
        $stmt = $conexao->prepare("UPDATE comentarios SET comentario = ?, created = NOW() WHERE id = ?");
        // Vincula os parâmetros da consulta: o comentário como string e o ID como inteiro
        $stmt->bind_param('si', $comentario, $id);
       
        // Executa a consulta de atualização
        if ($stmt->execute()) {
            // Redireciona para a página de comentários após a atualização bem-sucedida
            header('Location: comentarios.php?pagina=1');
            exit();
        } else {
            // Exibe uma mensagem de erro se a atualização falhar
            echo "Erro ao atualizar o comentário.";
        }
    }
}
?>