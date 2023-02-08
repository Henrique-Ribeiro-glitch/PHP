<?php
class Fornecedor
{

  private $idDoFornecedor;
  private $nome;
  private $sobrenome;
  private $numeroParaContato;
  private $email;
  private $endereco;

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
    return nl2br("Id: $this->idDoFornecedor
                  Nome: $this->nome
                  Sobrenome: $this->sobrenome
                  Numero Para Contato: $this->numeroParaContato
                  E-mail: $this->email
                  Endereço: $this->endereco");
  }

}
