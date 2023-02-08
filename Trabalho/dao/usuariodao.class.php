<?php
require_once 'conexaoBanco.class.php';
 class UsuarioDAO {

   private $conexao = null;

   public function __construct() {
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct() {

   }

   public function verificarUsuario($usuario){
     try{
       $statement = $this->conexao->prepare(
         "select * from usuario where login = ?
         and senha = ? and tipo = ?");

       $statement->bindValue(1, $usuario->login);
       $statement->bindValue(2, $usuario->senha);
       $statement->bindValue(3, $usuario->tipo);

       $statement->execute();

       $usuarioRetorno = null;
       $usuarioRetorno = $statement->fetchObject('Usuario');
       return $usuarioRetorno;
   }catch(PDOException $error){
       echo "Erro ao buscar usuarios! ".$error;
     }
   }
 }
