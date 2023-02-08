<?php
class Padronizacao
{

  public static function juntarNome($valor1, $valor2): string
  {
    $array = [$valor1, $valor2];
    return implode(" ", $array);
  }

  public static function padronizarNome($valor): string
  {
    return ucwords(strtolower($valor));
  }
  
  public static function padronizarEmail($valor): string
  {
    return strtolower($valor);
  }

}
