<?php
// Inicia uma nova sessão ou retoma uma sessão existente
session_start();
// Inclui o arquivo de conexão com o banco de dados
include_once 'conexao.php';

// Filtra e valida o dado do formulário para evitar injeções de código
$comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);
// Obtém o e-mail do usuário a partir da sessão
$email = $_SESSION['login'];

// Verifica se o e-mail está cadastrado na tabela 'dados'
$verifica_email = "SELECT id FROM dados WHERE Email = '$email'";
$result_email = mysqli_query($conexao, $verifica_email);

// Se o e-mail não está cadastrado, mostra uma mensagem de erro e redireciona
if (mysqli_num_rows($result_email) == 0) {
    $_SESSION['msg'] = "<p class='msg'>Email não cadastrado.</p>";
    header('location: comentarios.php?pagina=1');
} else {
    // Pega o ID do usuário associado ao e-mail
    $row = mysqli_fetch_assoc($result_email);
    $dados_id = $row['id'];

    // Insere o comentário na tabela 'comentários' com o ID do usuário, o comentário, o e-mail e a data/hora atual
    $criar_comentarios = "INSERT INTO comentarios (dados_id, comentario, email, created) VALUES ('$dados_id', '$comentario', '$email', now())";
    $comentario_criado = mysqli_query($conexao, $criar_comentarios);

    // Se o comentário for inserido com sucesso, redireciona para a página de comentários
    if ($comentario_criado) {
        //echo "Comentário adicionado com sucesso.";
        header('Location: comentarios.php?pagina=1');
        exit();
    } else {
        // Se houver um erro ao adicionar o comentário, mostra a mensagem de erro
        die("Erro ao adicionar o comentário: " . mysqli_error($conexao));
    }
}