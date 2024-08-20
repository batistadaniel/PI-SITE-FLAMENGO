<?php
session_start();
// Inicia ou retoma a sessão do usuário

include_once 'conexao.php';
// Inclui o arquivo de conexão com o banco de dados

// Verifica se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Filtra e sanitiza os dados enviados pelo formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);

    // Verifica se todos os campos estão preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($cpf)) {
        // Define uma mensagem de erro na sessão e redireciona para a página de cadastro
        $_SESSION['msg'] = "<p class='msg'>Por favor, preencha tudo.</p>";
        header("Location: cadastro.php");
        exit(); // Encerra o script para evitar execução adicional
    }

    // Consulta para verificar se o email já está cadastrado no banco de dados
    $query_verifica_email = "SELECT id FROM dados WHERE email = '$email'";
    $resultado_verifica_email = mysqli_query($conexao, $query_verifica_email);

    // Verifica se o CPF tem 11 dígitos e se é composto apenas por números
    if (strlen($cpf) == 11 && ctype_digit($cpf)) {

        // Consulta para verificar se o CPF já está cadastrado no banco de dados
        $query_verifica_cpf = "SELECT id FROM dados WHERE cpf = '$cpf'";
        $resultado_verifica_cpf = mysqli_query($conexao, $query_verifica_cpf);

        // Verifica se o email ou CPF já estão cadastrados no banco de dados
        if ((mysqli_num_rows($resultado_verifica_email) > 0) || (mysqli_num_rows($resultado_verifica_cpf) > 0)) {
            // Define uma mensagem de erro na sessão se o email ou CPF já estiverem cadastrados
            $_SESSION['msg'] = "<p class='msg'>Email ou CPF já cadastrado.</p>";
            header("location: cadastro.php");
            exit(); // Encerra o script
        }

        // Insere o novo usuário no banco de dados caso os dados sejam válidos
        $create_user = "INSERT INTO dados (nome, email, senha, cpf, created_data) VALUES ('$nome', '$email', '$senha', '$cpf', NOW())";
        $created_user = mysqli_query($conexao, $create_user);

        // Verifica se o cadastro foi bem-sucedido
        if ($created_user) {
            // Define uma mensagem de sucesso e redireciona para a página de cadastro
            $_SESSION['msg'] = "<p class='msg' style='color:green'>Usuário cadastrado com sucesso.</p>";
            header("location: cadastro.php");
        } else {
            // Define uma mensagem de erro se o cadastro falhar
            $_SESSION['msg'] = "<p class='msg'>Erro ao cadastrar usuário</p>";
            header("location: cadastro.php");
        }
    } else {
        // Define uma mensagem de erro se o CPF for inválido e redireciona
        $_SESSION['msg'] = "<p class='msg'>CPF invalido.</p>";
        header("location: cadastro.php");
    }
} else {
    // Redireciona para a página de cadastro se a requisição não for do tipo POST
    header("Location: cadastro.php");
}
