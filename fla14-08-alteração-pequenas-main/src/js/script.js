// Obtém o elemento do botão de login pelo ID
let btnLogin = document.getElementById('btn-login');
// Obtém o elemento da caixa de login pelo ID
let boxLogin = document.getElementById('box-login');
// Obtém o elemento da mensagem pelo ID
let msg = document.getElementById('msg');

// Função para alternar a visibilidade da caixa de login
function toggleLoginBox() {
    // Alterna a classe 'abrir-login' na caixa de login, mostrando ou escondendo a caixa
    boxLogin.classList.toggle('abrir-login');
}

// Adiciona um evento de clique ao botão de login
btnLogin.addEventListener('click', (event) => {
    // Impede a propagação do evento de clique para evitar conflitos
    event.stopPropagation();
    // Chama a função para alternar a visibilidade da caixa de login
    toggleLoginBox();
});

// Adiciona um evento de clique ao documento para fechar a caixa de login quando clicado fora dela
document.addEventListener('click', (event) => {
    // Verifica se a caixa de login está aberta e se o clique foi fora da caixa de login e do botão de login
    if (boxLogin.classList.contains('abrir-login') && !boxLogin.contains(event.target) && event.target !== btnLogin) {
        // Remove a classe 'abrir-login' para esconder a caixa de login
        boxLogin.classList.remove('abrir-login');
    }
});

// Função para mostrar e esconder a senha
function mostrarsenha() {
    // Obtém o campo de senha pelo ID
    var senha = document.getElementById('senha');
    // Obtém o botão de mostrar/esconder senha pelo ID
    var btnsenha = document.getElementById('btn-senha');

    // Verifica o tipo atual do campo de senha
    if (senha.type === 'password') {
        // Altera o tipo do campo para texto para mostrar a senha
        senha.setAttribute('type', 'text');
        // Substitui o ícone de olho aberto por olho fechado
        btnsenha.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        // Altera o tipo do campo para senha para esconder a senha
        senha.setAttribute('type', 'password');
        // Substitui o ícone de olho fechado por olho aberto
        btnsenha.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Mostra a mensagem
msg.style.display = 'block';
msg.style.top = '20px'; 

// Define um temporizador para apagar a mensagem após 4 segundos
setTimeout(() => {
    // Move a mensagem para fora da tela após 4 segundos
    msg.style.top = '-100%'; 
    // Define um segundo temporizador para esconder completamente a mensagem após o movimento
    setTimeout(() => {
        msg.style.display = 'none'; 
    }, 1000); 
}, 4000);
