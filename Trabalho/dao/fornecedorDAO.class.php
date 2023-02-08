<?php
require "conexaoBanco.class.php";
class FornecedorDAO {

  private $conexao = null;

  public function __construct() {
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function cadastrarFornecedor($fornecedor)
  {
    try {
        $statement = $this->conexao->prepare("insert into fornecedor(idfornecedor,nome,sobrenome,numeroParaContato,email,endereco)values(null,?,?,?,?,?)");

        $statement->bindValue(1, $fornecedor->nome);
        $statement->bindValue(2, $fornecedor->sobrenome);
        $statement->bindValue(3, $fornecedor->numeroParaContato);
        $statement->bindValue(4, $fornecedor->email);
        $statement->bindValue(5, $fornecedor->endereco);
        $statement->execute();

    } catch(PDOException $error) {
      echo "Erro ao cadastrar!".$error;
    }
  }
  public function buscarFornecedores()
  {
    try {
      $statement = $this->conexao->query("select * from fornecedor");
      $array = $statement->fetchAll(PDO::FETCH_CLASS, 'Fornecedor');
      return $array;
    } catch(PDOException $error) {
      echo "Erro ao buscar fornecedores!".$error;
    }
  }

  public function excluirFornecedor($id)
  {
    try {
      $statement = $this->conexao->prepare("delete from fornecedor where idfornecedor = ?");
      $statement->bindValue(1, $id);
      $statement->execute();
    } catch (PDOException $error) {
      echo "Erro ao excluir fornecedor!".$error;
    }
  }

  public function filtrarFornecedores($filtro, $pesquisa)
  {
    try {
      $query= "";
      switch($filtro) {
        case 'codigo': $query = "where idfornecedor =".$pesquisa;
        break;
        case 'nome': $query = "where nome like '%$pesquisa%'";
        break;
        case 'sobrenome': $query = "where sobrenome like '%$pesquisa%'";
        break;
        case 'numeroParaContato': $query = "where numeroParaContato like '%$pesquisa%'";
        break;
        case 'email': $query = "where email like '%$pesquisa%'";
        break;
        case 'endereco': $query = "where endereco like '%$pesquisa%'";
        break;
        default: $query = "";
        break;
      }

      $statement = $this->conexao->query("select * from fornecedor {$query}");
      return $statement->fetchAll(PDO::FETCH_CLASS, 'Fornecedor');
    } catch(PDOException $error) {
      echo "Erro ao filtrar fornecedor(es) ".$error;
    }
  }

  public function alterarFornecedor($fornecedor)
  {
    try {
      $statement = $this->conexao->prepare("update fornecedor set nome=?,sobrenome=?,numeroParaContato=?,email=?,endereco=? where idfornecedor=?");

      $statement->bindValue(1, $fornecedor->nome);
      $statement->bindValue(2, $fornecedor->sobrenome);
      $statement->bindValue(3, $fornecedor->numeroParaContato);
      $statement->bindValue(4, $fornecedor->email);
      $statement->bindValue(5, $fornecedor->endereco);
      $statement->bindValue(6, $fornecedor->idDoFornecedor);
      $statement->execute();

    } catch(PDOException $error) {
      echo "Erro ao alterar fornecedor! ".$error;
    }
  }

  public function gerarJSON($filtro, $pesquisa){
   try{
     $query="";
     switch($filtro){
       case "codigo": $query = "where idfornecedor = ".$pesquisa;
       break;
       default: $query = "";
       break;
     }
     $statement = $this->conexao->query("select * from fornecedor {$query}");
     return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
   }catch(PDOException $error){
     echo "Erro ao gerar JSON! ".$error;
   }
 }
}
