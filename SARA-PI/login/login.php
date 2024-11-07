<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css">
  <link rel="stylesheet" href="login.css" />

  <title>Login e Cadastro</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <h2>Bem vindo!</h2>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form action="processa_cadastro.php" method="POST">
        <h1>Crie sua conta</h1>
        <div class="social-container">
          <a href="https://www.facebook.com/v12.0/dialog/oauth" class="social"><i class="fa-brands fa-facebook"></i></a>
          <a href="https://accounts.google.com/o/oauth2/auth" class="social"><i class="fa-brands fa-google"></i></a>
        </div>
        <span>Ou use seu email registrado</span>
        <input type="text" name="nome" placeholder="Name" />
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="senha" placeholder="Password" />
        <button class="up">Cadastrar-se</button>
      </form>
    </div>
    <div class="form-container sign-in-container">
      <form action="processa_login.php" method="POST">
        <h1>Entrar</h1>
        <div class="social-container">
          <a href="https://www.facebook.com/v12.0/dialog/oauth" class="social"><i class="fa-brands fa-facebook"></i></a>
          <a href="https://accounts.google.com/o/oauth2/auth" class="social"><i class="fa-brands fa-google"></i></a>
        </div>

        <span>Ou use sua uma de suas contas</span>
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="senha" placeholder="Password" />
        <a href="#">Esqueceu sua senha?</a>
        <button class="in">Entrar</button>
      </form>
    </div>

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1><img class="img-pn" src="../assets/img/balão.png">Woba Hall</h1>
          <p>
            As celebrações nos unem, Woba Hall nos conecta! Do seu evento um sucesso.
          </p>
          <button class="ghost" id="signIn">Entrar</button>
        </div>
        <div class="overlay-panel overlay-right">
          <div class="balao">
            <h1><img class="img-pn" src="../assets/img/balão.png">Olá!</h1>
          </div>
          <p>Entre com suas informações pessoais e se junte a nós!</p>
          <button class="ghost" id="signUp">Cadastrar-se</button>
        </div>
      </div>
    </div>
  </div>

  <a class="bt_volta" id="volta" href="../home/home.html">Voltar</a>

  <script src="login.js"></script>
</body>

</html>