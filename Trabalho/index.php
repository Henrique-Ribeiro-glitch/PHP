//Henrique Júnior Trabalho sobre empresa
<?php
session_start();
ob_start();

require_once "modelo/usuario.class.php";

?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/ajax/lib/ajax.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos.css">
  </head>
  <body>

    <h1 class="jumbotron bg-info">Sistema</h1>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
       <a class="navbar-brand" href="#">Sistema</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav">
           <li class="nav-item active">
             <a class="nav-link" href="index.php">Home</a>
           </li>

           <?php
           if(isset($_SESSION['privateUser'])) {
             $usuario = unserialize($_SESSION['privateUser']);
             if($usuario->tipo == "rh") {
           ?>

          <li class="nav-item">
            <a class="nav-link" href="cadastro.php">Cadastrar Funcionario <span class="sr-only"></span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="buscar-funcionario.php">Consultar Funcionario(s) <span class="sr-only">(current)</span></a>
          </li>

          <?php
            }
          }
          if(isset($_SESSION['privateUser'])) {
            $usuario = unserialize($_SESSION['privateUser']);
            if($usuario->tipo == "adm") {
          ?>

          <li class="nav-item">
            <a class="nav-link" href="cadastro.php">Cadastrar Funcionario <span class="sr-only"></span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="buscar-funcionario.php">Consultar Funcionario(s) <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="cadastroDeFornecedor.php">Cadastrar Fornecedor <span class="sr-only"></span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="buscar-fornecedor.php">Consultar Fornecedor(es) <span class="sr-only">(current)</span></a>
          </li>

          <?php
            }
          }
          ?>

        </ul>
      </div>
    </nav>

    <?php
    if(isset($_SESSION['privateUser'])){
      require_once "modelo/usuario.class.php";
      $usuario = unserialize($_SESSION['privateUser']);
      echo "<h2>Olá {$usuario->login}, seja bem vindo!</h2>";
    ?>

    <form name="deslogar" method="post" action="">
      <div class="form-group">
        <input type="submit" name="deslogar" value="Sair" class="btn btn-primary">
      </div>
    </form>

    <?php
      if(isset($_POST['deslogar'])){
        unset($_SESSION['privateUser']);
        header("location:index.php");
      }

    } else {
    ?>

    <form name="login" method="post" action="">
      <div class="form-group">
        <input type="text" name="login" placeholder="Login" class="form-control" required pattern="^(Adm|RH)$">
      </div>

      <div class="form-group">
        <input type="password" name="senha" placeholder="Digite sua senha" class="form-control" required pattern="^(123456|654321)$">
      </div>

      <div class="form-group">
        <select name="tipo" class="form-control">
          <option value="adm">Adm</option>
          <option value="rh">RH</option>
        </select>
      </div>

      <div class="form-group">
        <input type="submit" name="entrar" value="Entrar" class="btn btn-info">
      </div>
    </form>

    <?php
    }

    if(isset($_POST['entrar'])){
     require_once 'modelo/usuario.class.php';
     require_once 'dao/usuariodao.class.php';
     require_once 'util/seguranca.class.php';

     $usuario = new Usuario();
     $usuario->login = $_POST['login'];
     $usuario->senha = Seguranca::criptografar($_POST['senha']);
     $usuario->tipo = $_POST['tipo'];

     $usuarioDAO = new UsuarioDAO();
     $usuario = $usuarioDAO->verificarUsuario($usuario);

     if($usuario == null){
       echo "<h2>Usuário ou senha inválido(s)!</h2>";
     }else{
       $_SESSION['privateUser'] = serialize($usuario);
       header("location:index.php");
     }
    }
    ?>

  </body>
</html>
