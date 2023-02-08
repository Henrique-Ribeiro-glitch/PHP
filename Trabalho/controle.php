<?php
session_start();
ob_start();

require_once "modelo/funcionario.class.php";
require_once "dao/funcionarioDAO.class.php";
require_once "util/seguranca.class.php";
require_once "util/padronizacao.class.php";
require_once "util/validacao.class.php";

$erros = [];

if(!Validacao::validarNome($_POST['nome'])) {
  $erros[] = "Nome inválido!";
}

if(!Validacao::validarNome($_POST['sobrenome'])) {
  $erros[] = "Sobrenome inválido!";
}

if(!Validacao::validarNumero($_POST['numeroParaContato'])) {
  $erros[] = "Numero inválido!";
}

if(!Validacao::validarEmail($_POST['email'])) {
  $erros[] = "E-mail inválido!";
}

if(!Validacao::validarSexo($_POST['sexo'])) {
  $erros[] = "Sexo inválido!";
}

if (count($erros) == 0) {
  $funcionario = new Funcionario;
  $funcionario->nome = Padronizacao::padronizarNome($_POST['nome']);
  $funcionario->sobrenome= Padronizacao::padronizarNome($_POST['sobrenome']);
  $funcionario->numeroParaContato = $_POST['numeroParaContato'];
  $funcionario->email = Padronizacao::padronizarEmail($_POST['email']);
  $funcionario->endereco = Padronizacao::padronizarNome($_POST['endereco']);
  $funcionario->idade = $_POST['idade'];
  $funcionario->sexo = Padronizacao::padronizarNome($_POST['sexo']);
  $funcionario->cargo = Padronizacao::padronizarNome($_POST['cargo']);

  $funcionarioDAO = new FuncionarioDAO;
  $funcionarioDAO->cadastrarFuncionario($funcionario);

  header("location:buscar-funcionario.php");

} else {
  $_SESSION['erros'] = serialize($erros);
  $_SESSION['post'] = serialize($_POST);

  header("location:cadastro.php");
}
ob_flush();
