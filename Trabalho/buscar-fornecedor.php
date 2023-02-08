<?php
session_start();
ob_start();
require_once "modelo/fornecedor.class.php";
require_once "dao/fornecedorDAO.class.php";
require_once "modelo/usuario.class.php";
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Consulta De Fornecedor(s)</title>
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
    <h1 class="jumbotron bg-primary">Consulta De Fornecedor(s)</h1>
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
          <?php
            }
          }
          ?>
        </ul>
      </div>
    </nav>
    <?php
    $fornecedorDAO = new FornecedorDAO;
      $fornecedores = $fornecedorDAO->buscarFornecedores();
      if(count($fornecedores) ==0) {
        echo "<h2>Não há fornecedores cadastrados!</h2>";
        echo "</body>";
        echo "</html>";
        die();
      }
      ?>
      <form name="pesquisa" method="post" action="">
        <div class="row">
          <div class="form-group col-md-7">
            <input type="text" name="pesquisa" class="form-control" placeholder="Digite sua pesquisa">
          </div>
          <div class="form-group col-md-5">
            <select name="filtro" class="form-control">
              <option value="todos">Todos</option>
              <option value="codigo">Id</option>
              <option value="nome">Nome</option>
              <option value="sobrenome">Sobrenome</option>
              <option value="numeroParaContato">Contato</option>
              <option value="email">Email</option>
              <option value="endereco">Endereco</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <input type="submit" name="filtrar" value="Filtrar"
          class="btn btn-primary btn-block">
        </div>
      </form>
      <?php
      if(isset($_POST['filtrar'])) {
        $fornecedorDAO = new FornecedorDAO;
        $fornecedores = $fornecedorDAO->filtrarFornecedores($_POST['filtro'], $_POST['pesquisa']);
        unset($_POST['filtrar']);
        if(count($fornecedores) == 0) {
          echo "<h2>Sua consulta não retornou fornecedor(es)</h2>";
          echo "</body>";
          echo "</html>";
          die();
        }
      }
      ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Sobrenome</th>
              <th>Contato</th>
              <th>Email</th>
              <th>Endereco</th>
              <th>Alterar</th>
              <th>Excluir</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Sobrenome</th>
              <th>Contato</th>
              <th>Email</th>
              <th>Endereco</th>
              <th>Alterar</th>
              <th>Excluir</th>
            </tr>
          </tfoot>
          <tbody>
          <?php
          foreach ($fornecedores as $fornecedor) {
            echo "<tr>";
            echo "<td>$fornecedor->idfornecedor</td>";
            echo "<td>$fornecedor->nome</td>";
            echo "<td>$fornecedor->sobrenome</td>";
            echo "<td>$fornecedor->numeroParaContato</td>";
            echo "<td>$fornecedor->email</td>";
            echo "<td>$fornecedor->endereco</td>";
            echo "<td><a href='alterar-fornecedor.php?id=$fornecedor->idfornecedor' class='btn btn-primary'>Alterar</a></td>";
            echo "<td><a href='buscar-fornecedor.php?id=$fornecedor->idfornecedor' class='btn btn-primary'>Excluir</a></td>";
            echo "<tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <div>
    <?php
      if (isset($_GET['id'])) {
        $fornecedorDAO = new FornecedorDAO;
        $fornecedorDAO->excluirFornecedor($_GET['id']);
        header("location:buscar-fornecedor.php");
      }
    ?>
    </div>
  </body>
</html>
