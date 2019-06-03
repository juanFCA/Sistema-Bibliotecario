<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logar no Sistema</title>
    <link href='assets/css/bootstrap.min.css' rel='stylesheet'/>
    <link href='assets/css/login.css' rel='stylesheet'/>
</head>
<body>
<div class="login-page">
  <div class="form">
      <div class="logo-login">
          <img src="assets/img/logo.jpg" height="150" width="200">
      </div>
      <?php
        if(isset($_GET['mensagem']) && isset($_GET['alerttype'])) {
      ?> <div class="alert <?=$_GET['alerttype']?> text-center" role="alert" id="divalert"><?=$_GET['mensagem']?></div>
      <?php
        }
      ?>
      <form class="register-form" method="post" action="cadastrar.php" id="formregister" name="formregister">
          <input type="text" placeholder="Nome de Usuario" name="login" id="login"/>
          <input type="password" placeholder="Senha" name="senha" id="senha"/>
          <input type="email" placeholder="Endereço de E-mail" name="email" id="email"/>
          <button>Registrar</button>
          <p class="message">Já possui Registro? <a href="#" id="logregister">Logar Agora</a></p>
      </form>
      <form class="recover-form" method="post" action="recuperar.php" id="formrecover" name="formrecover">
          <input type="email" placeholder="Endereço de E-mail" name="email" id="email"/>
          <button>Recuperar</button>
          <p class="message">Já recuperou a Senha? <a href="#" id="logrecover">Logar Agora</a></p>
      </form>
      <form class="login-form" method="post" action="logar.php" id="formlogin" name="formlogin">
          <input type="email" placeholder="Endereço de E-mail" name="email" id="email"/>
          <input type="password" placeholder="Senha " name="senha" id="senha"/>
          <button>Logar</button>
          <p class="message">Esqueceu a Senha? <a href="#" id="recover">Recuperar Conta</a></p>
          <p class="message">Não possui Registro? <a href="#" id="register">Crie uma Conta Agora</a></p>
      </form>
  </div>
</div>
</body>
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/js/rendered.js" type="text/javascript"></script>
</html>