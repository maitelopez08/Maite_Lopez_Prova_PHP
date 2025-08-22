function validarAlteracao() {
    let nome = document.getElementById("nome").value.trim();
    let email = document.getElementById("email").value.trim();
    let senhaInput = document.getElementById("nova_senha");
    let senha = senhaInput ? senhaInput.value.trim() : "";

    if (nome.length === 0) {
        alert("O campo Nome é obrigatório.");
        document.getElementById("nome").focus();
        return false;
    }

    if (nome.length < 3) {
        alert("O nome do usuário deve ter pelo menos 3 caracteres.");
        document.getElementById("nome").focus();
        return false;
    }

    let regexNumero = /\d/;
    if (regexNumero.test(nome)) {
        alert("O nome não pode conter números.");
        document.getElementById("nome").focus();
        return false;
    }

    if (email.length === 0) {
        alert("O campo Email é obrigatório.");
        document.getElementById("email").focus();
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        document.getElementById("email").focus();
        return false;
    }

    if (senhaInput) {
        if (senha.length === 0) {
            alert("O campo Senha é obrigatório.");
            senhaInput.focus();
            return false;
        }

        let regexSenha = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!regexSenha.test(senha)) {
            alert("A senha deve ter pelo menos 8 caracteres, incluindo letras e números.");
            senhaInput.focus();
            return false;
        }
    }

    return true;
}
