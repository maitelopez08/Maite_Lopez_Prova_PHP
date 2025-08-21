function validarAlteracao() {
    let nome = document.getElementById("nome").value.trim();
    let email = document.getElementById("email").value.trim();

    if (nome.length === 0) {
        alert("O campo Nome é obrigatório.");
        return false;
    }

    if (email.length === 0) {
        alert("O campo Email é obrigatório.");
        return false;
    }

    if (senha.length === 0) {
        alert("O campo Senha é obrigatório.");
        return false;
    }

    if (nome.length < 3) {
        alert("O nome do funcionário deve ter pelo menos 3 caracteres.");
        return false;
    }

    let regexNumero = /\d/;
    if (regexNumero.test(nome)) {
        alert("O nome não pode conter números.");
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    let regexSenha = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!regexSenha.test(senha)) {
        alert("A senha deve ter pelo menos 8 caracteres, incluindo letras e números.");
        return false;
    }

    return true;
}