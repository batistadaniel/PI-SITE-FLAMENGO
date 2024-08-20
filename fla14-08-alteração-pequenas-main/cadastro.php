<?php
// Inicia uma nova sessão ou retoma uma sessão existente
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres para o documento -->
    <meta charset="UTF-8">
    <!-- Define a compatibilidade com o Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Define a configuração da viewport para dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclui os ícones do Bootstrap para uso no documento -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Inclui o script JavaScript para funcionalidades adicionais -->
    <script src="src/js/script.js" defer></script>
    <!-- Inclui a folha de estilos CSS específica para a página de cadastro -->
    <link rel="stylesheet" href="./src/css/cadastro.css">
    <!-- Define o título da página -->
    <title>Cadastre-se</title>
</head>

<body>
    <?php
    // Verifica se há uma mensagem na sessão e exibe se houver
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        // Remove a mensagem da sessão após exibição
        unset($_SESSION['msg']);
    }
    ?>
     <div class="formulario">
        <!-- Formulário para envio de dados de cadastro -->
        <form action="envio.php" method="post">
            <div class="logo">
                <!-- Imagem do logo exibida no formulário -->
                <img src="https://images.mengo.com.br/prod/assets/images/logo-st-nova.png" alt="">
            </div>
            <div class="inputs">
                <!-- Campo de entrada para o nome completo -->
                <input type="text" name="nome" placeholder="Nome Completo">
                <!-- Campo de entrada para o e-mail -->
                <input type="email" name="email" placeholder="E-mail">
                <!-- Campo de entrada para a senha -->
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <!-- Ícone para mostrar ou esconder a senha -->
                <i class="bi bi-eye" id="btn-senha" onclick="mostrarsenha()"></i>
                <!-- Campo de entrada para o CPF, apenas números -->
                <input type="text" name="cpf" placeholder="CPF(apenas numeros)">
                <div class="btns">
                    <!-- Botão para submeter o formulário -->
                    <button type="submit">Criar</button>
                    <!-- Botão para voltar à página de login -->
                    <button type="button"><a href="login.php">Voltar</a></button>
                </div>
            </div>
        </form>
    </div>
    
</body>

</html>