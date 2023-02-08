<?php
class Usuario {

  private $idUsuario;
  private $login;
  private $senha;
  private $tipo;

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
    return nl2br("login: $this->login
                  senha: $this->senha
                  tipo: $this->tipo");
  }

  /*
  senha: Aula123456PHP
  insert into usuario(idusuario,login,senha,tipo)
  values(1,"Adm,"1f591a4c440e29f36bc86358a832dcd1", "adm")
  */
  /*
  senha: Aula654321PHP
  insert into usuario(idusuario,login,senha,tipo)
  values(2,"RH","d5272dceb7b70501087840b295035d3b", "rh")
  */
}
