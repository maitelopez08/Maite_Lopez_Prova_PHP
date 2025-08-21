<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastrar Usuário</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Cadastrar Usuário</h2>

  <!-- IMPORTANTE: onsubmit retorna o resultado da função -->
  <form id="formCadastro" action="cadastro_usuario.php" method="POST" onsubmit="return validarUsuario()">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha">

    <label for="id_perfil">Perfil:</label>
    <select id="id_perfil" name="id_perfil">
      <option value="1">Administrador</option>
      <option value="2">Secretaria</option>
      <option value="3">Almoxarife</option>
      <option value="4">Cliente</option>
    </select>

    <button type="submit">Salvar</button>
    <button type="reset">Cancelar</button>
  </form>

  <div class="voltar">
    <a class="link" href="principal.php">Voltar</a>
  </div>

  <!-- JS inline só pra garantir o funcionamento -->
  <script>
    function validarUsuario() {
      console.log("validarUsuario foi chamado"); // debug

      const nome  = document.getElementById("nome").value.trim();
      const email = document.getElementById("email").value.trim();
      const senha = document.getElementById("senha").value;

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
      const regexNumero = /\d/;
      if (regexNumero.test(nome)) {
        alert("O nome não pode conter números.");
        return false;
      }
      const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
      }
      const regexSenha = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
      if (!regexSenha.test(senha)) {
        alert("A senha deve ter pelo menos 8 caracteres, incluindo letras e números.");
        return false;
      }
      return true; // libera o submit
    }
  </script>
</body>
</html>
