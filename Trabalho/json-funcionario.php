<?php
//json-livro.php
require_once "dao/funcionarioDAO.class.php";
require_once "modelo/funcionario.class.php";

http://localhost/Trabalho/json-funcionario.php

$funcionarioDAO = new FuncionarioDAO;
if(isset($_GET['id'])) {
  echo $funcionarioDAO->gerarJSON("codigo", $_GET['id']);
} else {
  echo $funcionarioDAO->gerarJSON("","");
}
