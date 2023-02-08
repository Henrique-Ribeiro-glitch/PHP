<?php
class Validacao
{
  public static function validarNome($valor): bool
  {
    $expressao = "/^[\wÀ-ü ]{1,30}$/";
    return preg_match($expressao, $valor);
  }

  public static function validarNumero($valor): bool
  {
    $expressao = "/^[\d()-]{8,20}$/";
    return preg_match($expressao, $valor);
  }

  public static function validarEmail($valor): bool
  {
    return filter_var($valor, FILTER_VALIDATE_EMAIL);
  }

  public static function validarSexo($valor): bool
  {
    $expressao = "/^(Masculino|Feminino)$/";
    return preg_match($expressao, $valor);
  }

}
