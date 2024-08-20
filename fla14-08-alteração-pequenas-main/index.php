<?php
// Inicia uma nova sessão ou resume a sessão existente
session_start();

// Inclui o arquivo de conexão com o banco de dados
include_once('conexao.php');

// Verifica se há uma mensagem de alerta na sessão
if (isset($_SESSION['alert_message'])) {
    // Exibe uma mensagem de alerta no navegador
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    // Remove a mensagem de alerta da sessão após ser exibida
    unset($_SESSION['alert_message']);
}

// Verifica se o usuário já está logado
if (isset($_SESSION['login'])) {
    // Verifica se foi solicitado o logout
    if (isset($_GET['logout'])) {
        // Remove a variável de sessão 'login' e destrói a sessão
        unset($_SESSION['login']);
        session_destroy();
        // Redireciona o usuário para a página de login
        header('Location: login.php');
        exit(); // Encerra a execução do script após o redirecionamento
    }   

    // Inclui a página inicial (home) se o usuário estiver logado
    include('home.php');
    exit(); // Encerra a execução do script após incluir a página home
} 

// Verifica se o formulário de login foi enviado
if (isset($_POST['acao'])) {
    // Obtém e sanitiza o e-mail do formulário, removendo caracteres perigosos
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // Obtém e sanitiza a senha do formulário
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    // Prepara a consulta SQL para verificar se o e-mail e a senha existem na base de dados
    $verifica = "SELECT * FROM dados WHERE email= '$email' AND senha = '$senha'";
    // Executa a consulta SQL
    $resultado = mysqli_query($conexao, $verifica);

    // Verifica se a consulta retornou algum resultado (usuário válido)
    if ($resultado->num_rows > 0) {
        // Se válido, define a variável de sessão 'login' com o e-mail do usuário
        $_SESSION['login'] = $email;
        // Redireciona o usuário para a página inicial (index)
        header('Location: index.php');
        exit(); // Encerra a execução do script após o redirecionamento
    } else {
        // Se os dados estiverem incorretos, armazena uma mensagem de erro
        $error_message = "E-mail ou senha inválidos!";
    }
}

// Inclui a página de login se o usuário não estiver logado
include('login.php');
?>
