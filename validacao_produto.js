function validarProduto() {
    let nome = document.getElementById("nome_prod").value.trim();
    let descricao = document.getElementById("descricao").value.trim();
    let qtde = document.getElementById("qtde").value.trim();
    let valor_unit = document.getElementById("valor_unit").value.trim();


    if (nome.length === 0) {
        alert("O campo Nome é obrigatório.");
        return false;
    }

    if (nome.length < 3) {
        alert("O nome do produto deve ter pelo menos 3 caracteres.");
        return false;
    }

    if (descricao.length === 0) {
        alert("O campo Descrição é obrigatório.");
        return false;
    }

    let regexQtde = /^[1-9]\d*$/;
    if (!regexQtde.test(qtde)) {
        alert("A quantidade deve ser um número inteiro maior que zero.");
        return false;
    }

    let regexValor = /^\d+(\.\d{1,2})?$/;
    if (!regexValor.test(valor_unit) || parseFloat(valor_unit) <= 0) {
        alert("O valor unitário deve ser um número positivo (até 2 casas decimais).");
        return false;
    }

    return true;
} 









