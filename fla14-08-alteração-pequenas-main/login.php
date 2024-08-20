<!DOCTYPE html>
<html lang="pt-BR">
<!-- Declaração do tipo de documento HTML5 e define o idioma da página como Português-Brasil -->

<head>
    <meta charset="UTF-8">
    <!-- Define a codificação de caracteres como UTF-8 para suportar caracteres especiais -->

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Garante que o site seja renderizado corretamente em navegadores mais antigos -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Faz com que a página seja responsiva, ajustando-se ao tamanho da tela do dispositivo -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Inclui a biblioteca de ícones "Bootstrap Icons" via CDN -->

    <link rel="stylesheet" href="src/css/index.css">
    <!-- Inclui o arquivo de estilos CSS personalizado localizado no diretório 'src/css/index.css' -->

    <title>Nação</title>
    <!-- Define o título da página como "Nação" -->
</head>

<body>

    <header id="login">
        <!-- Cabeçalho exibido quando o usuário não está logado -->
        <button class="btn-login" type="button" id="btn-login">
            <p>Login</p>
            <!-- Botão de login -->
        </button>
    </header>

    <header id="logado" style="display: none;">
        <!-- Cabeçalho exibido quando o usuário está logado, inicialmente oculto via CSS (display: none) -->
        <div class="logo-mobile">
            <!-- Logo do site na versão mobile -->
            <a href="#"><img src="src/img/logo-crf.png" alt="Logo CRF" class="logo-mobile"></a>
        </div>
        <div class="titulo">
            <!-- Título do site -->
            <a href="#">
                <h1>Feed do Urubu</h1>
            </a>
        </div>
        <div class="icone-perfil">
            <!-- Ícone de perfil (usuário logado) -->
            <i class="bi bi-person-circle"></i>
        </div>
    </header>
    
    <?php
    // Exibe uma mensagem de erro, caso exista, vinda do backend (PHP)
    if (isset($error_message)) {
        echo "<h3 class='msg' id='msg'>$error_message</h3>";
    }
    ?>

    <main id="box-login">
        <!-- Seção principal com o formulário de login -->

        <div class="container">
            <!-- Container principal que centraliza o conteúdo -->

            <div class="logo">
                <!-- Logo principal do Flamengo -->
                <img src="src/img/logo-flamengo.webp" alt="Logo Flamengo">
            </div>
            <div class="logo-mobile">
                <!-- Logo para versão mobile -->
                <img src="src/img/logo-crf.png" alt="Logo CRF" class="logo-mobile">
            </div>
            <div class="formulario">
                <!-- Formulário de login -->
                <form id="loginForm" action="index.php" method="post">
                    <!-- O formulário envia os dados via POST para a página 'index.php' -->

                    <div class="inputs">
                        <!-- Campo de entrada de e-mail -->
                        <input class="email" name="email" id="email" required type="email">
                        <label class="input-label">E-mail</label>

                        <!-- Campo de entrada de senha -->
                        <input class="senha" name="senha" id="senha" required type="password">
                        <label class="input-senha">Senha</label>

                        <!-- Ícone de mostrar/ocultar senha -->
                        <i class="bi bi-eye" id="btn-senha" onclick="mostrarsenha()"></i>

                        <!-- Botão de envio do formulário -->
                        <button class="but" type="submit" name="acao"><strong>Entrar</strong></button>

                        <!-- Link para a página de cadastro -->
                        <a href="cadastro.php" target="_blank"><strong>Cadastre-se</strong></a>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <!-- Inclui o arquivo de script JavaScript que contém as interações da página -->
    <script src="src/js/script.js" defer></script>
</body>

</html>
