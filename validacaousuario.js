function validarUsuario() {
    let nome = document.getElementById("nome").value.trim();
    let email = document.getElementById("email").value.trim();
    let senha = document.getElementById("senha").value;

    if (nome.length < 3) {
        alert("O nome do funcionário deve ter pelo menos 3 caracteres.");
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    let regexSenha = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexsenha.test(senha)) {
        alert("Senha Inválida.");
        return false;
    }

    return true;
}
