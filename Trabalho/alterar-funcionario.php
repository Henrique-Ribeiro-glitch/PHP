<?php
session_start();
ob_start();

require_once "modelo/funcionario.class.php";
require_once "dao/funcionarioDAO.class.php";
require_once "modelo/usuario.class.php";
require_once "util/seguranca.class.php";

if(isset($_GET['id'])) {
  $funcionarioDAO = new FuncionarioDAO;
  $funcionarios = $funcionarioDAO->filtrarFuncionarios("codigo", $_GET['id']);
  $funcionario = $funcionarios[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Alterar Funcionario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/ajax/lib/ajax.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
    if(!isset($_SESSION['privateUser'])){
      echo "<h2>Você não tem permissão para acessar essa página</h2>";
      echo "</body>";
      echo "</html>";
      die();
    }
    ?>
    <h1 class="jumbotron bg-primary">Alterar Funcionario</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Sistema</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
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
              <li class="nav-item active">
                <a class="nav-link" href="buscar-funcionario.php">Consultar Fornecedor <span class="sr-only">(current)</span></a>
              </li>
              <?php
            }
          }
          ?>
          <?php
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
    <form name="alterar" method="post" action="">
      <div class="form-group">
        <input type="text" name="codigo" class="form-control"
        value="<?php echo $funcionario->idfuncionario ?? ""; ?>" hidden readonly>
      </div>
      <div class="form-group">
        <input type="text" name="nome" placeholder="Digite o nome do funcionario" autofocus class="form-control" required pattern="^[\wÀ-ü ]{5,30}$" value="<?php echo $funcionario->nome ?? ""; ?>">
      </div>
      <div class="form-group">
        <input type="text" name="sobrenome" placeholder="Digite o sobrenome" class="form-control" required pattern="^[\wÀ-ü ]{5,30}$" value="<?php echo $funcionario->sobrenome ?? ""; ?>">
      </div>
      <div class="form-group">
        <input type="number" name="numeroParaContato" placeholder="Digite um número pra contato" class="form-control" required pattern="^[\d()-]{8,20}$" value="<?php echo $funcionario->numeroParaContato ?? ""; ?>">
      </div>
      <div class="form-group">
        <input type="text" name="email" placeholder="Digite o email" class="form-control" required pattern="^[\wÀ-ü@]{15,30}$" value="<?php echo $funcionario->email ?? ""; ?>">
      </div>
      <div class="form-group">
        <input type="text" name="endereco" placeholder="Digite o endereço" class="form-control" required pattern="^[\wÀ-ü ]{8,30}$" value="<?php echo $funcionario->endereco ?? ""; ?>">
      </div>
      <div class="form-group">
        <input type="number" name="idade" placeholder="Digite a idade" class="form-control" required pattern="^[\d]{2,3}$" value="<?php echo $funcionario->idade ?? ""; ?>">
      </div>

      <div class="form-group">
        <input type="text" name="cargo" placeholder="Digite o cargo" class="form-control"required pattern="^[\wÀ-ü ]{8,30}$" value="<?php echo $funcionario->cargo ?? ""; ?>">
      </div>
      <div class="form-control">
        <label>
          <input type="radio" required pattern="^(Masculino)$" name="sexo" value="Masculino" value="<?php echo $post['sexo'] ?? ""; ?>">Masculino</label>
        <label>
          <input type="radio" required pattern="^(Feminino)$" name="sexo" value="Feminino" value="<?php echo $post['sexo'] ?? ""; ?>">Feminino </label>
      </div>
    	<div class="form-group">
        <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
      </div>
    </form>
    <?php
    require_once "util/padronizacao.class.php";

    if(isset($_POST['alterar'])) {
      $funcionario = new Funcionario;
      $funcionario->idDoFuncionario = $_POST["codigo"];
      $funcionario->nome = Padronizacao::padronizarNome(Seguranca::antiXSS($_POST["nome"]));
      $funcionario->sobrenome = Padronizacao::padronizarNome(Seguranca::antiXSS($_POST["sobrenome"]));
      $funcionario->numeroParaContato = Seguranca::antiXSS($_POST["numeroParaContato"]);
      $funcionario->email = Seguranca::antiXSS($_POST["email"]);
      $funcionario->endereco = Padronizacao::padronizarNome(Seguranca::antiXSS($_POST["endereco"]));
      $funcionario->idade = Seguranca::antiXSS($_POST["idade"]);
      $funcionario->sexo = Padronizacao::padronizarNome(Seguranca::antiXSS($_POST["sexo"]));
      $funcionario->cargo = Padronizacao::padronizarNome(Seguranca::antiXSS($_POST["cargo"]));

      $funcionarioDAO = new FuncionarioDAO;
      $funcionarioDAO->alterarFuncionario($funcionario);
      header("location:buscar-funcionario.php");
    }
    ?>
  </body>
</html>
