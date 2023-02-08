<?php
class Funcionario
{

  private $idDoFuncionario;
  private $nome;
  private $sobrenome;
  private $numeroParaContato;
  private $email;
  private $endereco;
  private $idade;
  private $sexo;
  private $cargo;

  public function __construct() {
  }

  public function __destruct() {
  }

  public function __get($atributo) {
    return $this->$atributo;
  }

  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }

  public function __toString() {
    return nl2br("Id: $this->idDoFuncionario
                  Nome: $this->nome
                  Sobrenome: $this->sobrenome
                  Numero Para Contato: $this->numeroParaContato
                  E-mail: $this->email
                  Endereço: $this->endereco
                  Idade: $this->idade
                  Sexo: $this->sexo
                  Cargo: $this->cargo");
  }

}
