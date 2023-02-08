<?php
session_start();
ob_start();

require_once "modelo/fornecedor.class.php";
require_once "dao/fornecedorDAO.class.php";
require_once "util/padronizacao.class.php";
require_once "util/validacao.class.php";

$erros = [];

if (!Validacao::validarNome($_POST['nome'])) {
  $erros[] = "Nome inválido!";
}

if(!Validacao::validarNome($_POST['sobrenome'])) {
  $erros[] = "Sobrenome inávalido!";
}

if(!Validacao::validarNumero($_POST['numeroParaContato'])) {
  $erros[] = "Numero inávalido!";
}

if(!Validacao::validarEmail($_POST['email'])) {
  $erros[] = "E-mail inválido!";
}

if (count($erros) == 0) {
  $fornecedor = new Fornecedor;
  $fornecedor->nome = Padronizacao::padronizarNome($_POST['nome']);
  $fornecedor->sobrenome = Padronizacao::padronizarNome($_POST['sobrenome']);
  $fornecedor->numeroParaContato = $_POST['numeroParaContato'];
  $fornecedor->email = Padronizacao::padronizarEmail($_POST['email']);
  $fornecedor->endereco = Padronizacao::padronizarNome($_POST['endereco']);

  $fornecedorDAO = new FornecedorDAO;
  $fornecedorDAO->cadastrarFornecedor($fornecedor);

  header("location:buscar-fornecedor.php");
} else {
  $_SESSION['erros'] = serialize($erros);
  $_SESSION['post'] = serialize($_POST);
  header("location:cadastroDeFornecedor.php");
}
ob_flush();
