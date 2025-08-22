function validarAlteracaoProduto() {
    let nome = document.getElementById("nome_prod").value.trim();
    let descricao = document.getElementById("descricao").value.trim();
    let qtde = document.getElementById("qtde").value.trim();
    let valor_unit = document.getElementById("valor_unit").value.trim();

    if (nome.length === 0) {
        alert("O campo Nome é obrigatório.");
        document.getElementById("nome_prod").focus();
        return false;
    }

    if (nome.length < 3) {
        alert("O nome do produto deve ter pelo menos 3 caracteres.");
        document.getElementById("nome_prod").focus();
        return false;
    }

    if (descricao.length === 0) {
        alert("O campo Descrição é obrigatório.");
        document.getElementById("descricao").focus();
        return false;
    }

    if (descricao.length < 5) {
        alert("A descrição deve ter pelo menos 5 caracteres.");
        document.getElementById("descricao").focus();
        return false;
    }

    let regexQtde = /^[1-9]\d*$/;
    if (!regexQtde.test(qtde)) {
        alert("A quantidade deve ser um número inteiro maior que zero.");
        document.getElementById("qtde").focus();
        return false;
    }

    valor_unit = valor_unit.replace(",", ".");
    let regexValor = /^\d+(\.\d{1,2})?$/;
    if (!regexValor.test(valor_unit) || parseFloat(valor_unit) <= 0) {
        alert("O valor unitário deve ser um número positivo (com até 2 casas decimais).");
        document.getElementById("valor_unit").focus();
        return false;
    }

    return true;
}


