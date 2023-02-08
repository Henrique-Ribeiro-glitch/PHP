<?php
class Seguranca
{

  public static function antiXSS($valor)
  {
    return htmlentities($valor);
  }

  public static function criptografar($valor)
  {
    return md5('Aula'.$valor.'PHP');
  }

}
