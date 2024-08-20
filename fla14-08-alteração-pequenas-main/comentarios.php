<?php
session_start();
// Inicia a sessão do usuário

// Verifica se o usuário está logado
if (!isset($_SESSION['login'])) {
    // Se não estiver logado, define uma mensagem de alerta e redireciona para a página inicial
    $_SESSION['alert_message'] = 'Você precisa estar logado para acessar esta página!';
    header('Location: index.php');
    exit(); // Encerra o script
}

include_once 'conexao.php';
// Inclui o arquivo de conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="src/css/comentarios.css">
    <title>Nação - Comentarios</title>
</head>

<body>

    <header>
        <!-- Cabeçalho da página -->

        <div class="logo-mobile">
            <!-- Exibe a logo do Flamengo na versão mobile -->
            <a href="#"><img src="src/img/logo-crf.png" alt="Logo CRF" class="logo-mobile"></a>
        </div>

        <div class="titulo">
            <!-- Título da página -->
            <a href="#">
                <h1>Feed do Urubu</h1>
            </a>
        </div>

        <div id="dropdow-menu" class="dropdown-menu">
            <!-- Menu de navegação dropdown -->
            <?php
            // Exibe o link para a página inicial
            echo '<a style="color:#fff" href="index.php" id="home-button">Home</a>';
            ?>
        </div>

        <div id="icone-perfil" class="icone-perfil">
            <!-- Ícone do perfil do usuário -->

            <?php
            // Verifica se a sessão está iniciada
            if (isset($_SESSION['login'])) {
                // Obtém o email da sessão
                $email = $_SESSION['login'];

                // Prepara uma consulta para buscar o nome do usuário com base no email
                $query = "SELECT nome FROM dados WHERE email = ?";
                $stmt = mysqli_prepare($conexao, $query);
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $nome);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                // Exibe o nome do usuário se encontrado
                if (!empty($nome)) {
                    echo "<h3 class='nome-comentario'>$nome</h3>";
                } else {
                    echo "<h3 class='nome-comentario'>Nome não encontrado</h3>";
                }
            }
            ?>
            <!-- Ícone de perfil -->
            <i class="bi bi-person-circle"></i>
        </div>
    </header>

    <main>
        <section class="sessao-comentario">
            <!-- Seção de comentários -->

            <form action="processa_comentario.php" method="post">
                <!-- Formulário para enviar um comentário -->

                <div class="box-comentario">
                    <textarea type="text" name="comentario" id="" placeholder="Deixe seu comentario..." required></textarea>
                </div>
                <!-- Campo para o usuário inserir o comentário -->

                <button class="btn-comentario" type="submit">Comentar</button>
                <!-- Botão para enviar o comentário -->
            </form>

            <?php
            // Verifica se a URL contém um parâmetro de deleção
            if (isset($_GET['delete'])) {
                $id = (int)$_GET['delete']; // Obtém o ID do comentário
                if ($id > 0) {
                    // Deleta o comentário com o ID especificado
                    $delete = "DELETE FROM comentarios WHERE id = $id";
                    if (mysqli_query($conexao, $delete) === true) {
                        // Redireciona para a primeira página de comentários após a deleção
                        header("Location: comentarios.php?pagina=1");
                        exit();
                    }
                }
            }

            // Paginação dos comentários
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

            // Define o número de resultados por página
            $qnt_result_pg = 5;

            // Calcula o início da exibição dos resultados
            $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

            // Consulta para selecionar os comentários e dados do usuário
            $select_user = "SELECT c.id , d.nome, c.comentario, c.created, c.email  FROM dados d LEFT JOIN comentarios c ON d.id = c.dados_id ORDER BY c.created DESC LIMIT  $inicio, $qnt_result_pg";
            $selected_user = mysqli_query($conexao, $select_user);

            // Loop para exibir os comentários da página atual
            while ($row_user = mysqli_fetch_assoc($selected_user)) {
                if (!empty($row_user['comentario'])) {
                    $comentario_id = $row_user['id'];
                    $nome = $row_user['nome'];
                    $data = date('d/m/Y H:i', strtotime($row_user['created']));

                    echo "<div id='comentario-$comentario_id' class='comentario-container'>";
                        echo "<div class='comentario' id='comentario-text-$comentario_id'>";
                            echo "<div class='top-comentario'>";
                                echo "<h3 class='nome-comentario'>$nome</h3>";
                                echo "<p class='data-comentario'>$data</p>";
                            echo "</div>";
                            echo "<p class='texto-comentario'>".$row_user['comentario']."</p>";

                    // Conta o número total de registros para a paginação
                    $result_pg = "SELECT COUNT(id) as num_result FROM comentarios";
                    $resultado_pg = mysqli_query($conexao, $result_pg);
                    $row_pg = mysqli_fetch_assoc($resultado_pg);

                    // Calcula a quantidade total de páginas
                    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

                    // Verifica se o email da sessão é o mesmo do comentário para permitir edição/exclusão
                    if ($_SESSION['login'] == $row_user['email']) {

                        echo "<div class='btn-acao'>";
                            // Botão de editar comentário
                            echo "<a href='#' class='btn-editar' onclick='editarComentario($comentario_id)'>";
                                echo "<i class='bi bi-pen'></i>";
                            echo "</a>";
                            // Botão de excluir comentário
                            echo "<a href='?delete=$comentario_id' class='btn-excluir'>";
                                echo "<i class='bi bi-trash-fill'></i>";
                            echo "</a>";
                        echo "</div>";
                    }

                    echo "</div>";

                    // Formulário de edição de comentário (inicialmente escondido)
                    echo "<div id='edit-form-$comentario_id' class='edit-form' style='display: none;'>";
                        echo "<form action='update_comentario.php' method='POST'>";
                            echo "<input type='hidden' name='id' value='$comentario_id'>";
                            echo "<textarea class='comentario' name='comentario' required>".$row_user['comentario']."</textarea>";
                            echo "<div class='btn-acao-edit'>";
                                echo "<button class='btn-editar2' type='submit'>Salvar</button>";
                                echo "<button class='btn-editar2' type='button' onclick='cancelarEdicao($comentario_id)'>Cancelar</button>";
                            echo "</div>";
                        echo "</form>";
                    echo "</div>";

                    echo "<hr>";
                }
            }

            // Paginação: links para navegar entre as páginas de comentários
            echo "<div class='paginacao'>";
                $max_links = 1;

                // Link para a primeira página
                echo "<a class='primeira_pag' href='comentarios.php?pagina=1'>Primeira</a>";

                // Links para as páginas anteriores
                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        echo "<a class='pagina_ant' href='comentarios.php?pagina=$pag_ant'>$pag_ant</a>";
                    }
                }

                // Exibe a página atual
                echo "<p class='pagina_atual'>$pagina_atual</p>";

                // Links para as páginas seguintes
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) {
                        echo "<a class='pag_dep' href='comentarios.php?pagina=$pag_dep'>$pag_dep</a>";
                    }
                }

                // Link para a última página
                echo "<a class='ultima_pag' href='comentarios.php?pagina=$quantidade_pg'>Última</a>";
            echo "</div>";
            ?>
        </section>
    </main>

    <script defer>
        function editarComentario(id) {
            document.getElementById('comentario-text-' + id).style.display = 'none';
            document.getElementById('edit-form-' + id).style.display = 'block';
        }

        function cancelarEdicao(id) {
            document.getElementById('comentario-text-' + id).style.display = 'block';
            document.getElementById('edit-form-' + id).style.display = 'none';
        }

        let iconePerfil = document.getElementById('icone-perfil');
        let dropdownMenu = document.getElementById('dropdow-menu');

        iconePerfil.addEventListener('click', (event) => {
            // Previne que o clique no ícone feche o menu imediatamente
            event.stopPropagation();
            // Alterna a visibilidade do menu
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (event) => {
            // Verifica se o clique foi fora do ícone e do menu
            if (!iconePerfil.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none'; // Oculta o menu
            }
        });

        function mostraSection(sectionId) {

            // Logica pra ocultar todas as secoes
            let secoes = document.getElementsByTagName('section'); // Conta todas as secoes pela tag 
            for (let i = 0; i < secoes.length; i++) {
                secoes[i].style.display = 'none';
            }
            
            // Exibe a secao que foi clicada passando um parametro que e o Id da secao
            let secao = document.getElementById(sectionId);
            secao.style.display = 'flex';

            // Oculta o menu quando clica em uma opcao 
            dropdownMenu.style.display = 'none';

        }
    </script>
</body>

</html>