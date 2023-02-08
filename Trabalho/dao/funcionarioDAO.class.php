<?php
require "conexaoBanco.class.php";
class FuncionarioDAO {

  private $conexao = null;

  public function __construct() {
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function cadastrarFuncionario($funcionario)
  {
    try {
        $statement = $this->conexao->prepare("insert into funcionario(idfuncionario,nome,sobrenome,numeroParaContato,email,endereco,idade,sexo,cargo)values(null,?,?,?,?,?,?,?,?)");

        $statement->bindValue(1, $funcionario->nome);
        $statement->bindValue(2, $funcionario->sobrenome);
        $statement->bindValue(3, $funcionario->numeroParaContato);
        $statement->bindValue(4, $funcionario->email);
        $statement->bindValue(5, $funcionario->endereco);
        $statement->bindValue(6, $funcionario->idade);
        $statement->bindValue(7, $funcionario->sexo);
        $statement->bindValue(8, $funcionario->cargo);
        $statement->execute();

    } catch(PDOException $error) {
      echo "Erro ao cadastrar!".$error;
    }
  }
  public function buscarFuncionarios()
  {
    try {
      $statement = $this->conexao->query("select * from funcionario");
      $array = $statement->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
      return $array;
    } catch(PDOException $error) {
      echo "Erro ao buscar funcionarios!".$error;
    }
  }

  public function excluirFuncionario($id)
  {
    try {
      $statement = $this->conexao->prepare("delete from funcionario where idfuncionario = ?");
      $statement->bindValue(1, $id);
      $statement->execute();
    } catch (PDOException $error) {
      echo "Erro ao excluir funcionarios!".$error;
    }
  }

  public function filtrarFuncionarios($filtro, $pesquisa)
  {
    try {
      $query= "";
      switch($filtro) {
        case 'codigo': $query = "where idfuncionario =".$pesquisa;
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
        case 'idade': $query = "where idade like '%$pesquisa%'";
        break;
        case 'sexo': $query = "where sexo like '%$pesquisa%'";
        break;
        case 'cargo': $query = "where cargo like '%$pesquisa%'";
        break;
        default: $query = "";
        break;
      }

      $statement = $this->conexao->query("select * from funcionario {$query}");
      return $statement->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
    } catch(PDOException $error) {
      echo "Erro ao filtrar funcionario(s) ".$error;
    }
  }

  public function alterarFuncionario($funcionario)
  {
    try {
      $statement = $this->conexao->prepare("update funcionario set nome=?,sobrenome=?,numeroParaContato=?,email=?,endereco=?,idade=?,sexo=?,cargo=? where idfuncionario=?");

      $statement->bindValue(1, $funcionario->nome);
      $statement->bindValue(2, $funcionario->sobrenome);
      $statement->bindValue(3, $funcionario->numeroParaContato);
      $statement->bindValue(4, $funcionario->email);
      $statement->bindValue(5, $funcionario->endereco);
      $statement->bindValue(6, $funcionario->idade);
      $statement->bindValue(7, $funcionario->sexo);
      $statement->bindValue(8, $funcionario->cargo);
      $statement->bindValue(9, $funcionario->idDoFuncionario);
      $statement->execute();

    } catch(PDOException $error) {
      echo "Erro ao alterar funcionario! ".$error;
    }
  }

  public function gerarJSON($filtro, $pesquisa){
   try{
     $query="";
     switch($filtro){
       case "codigo": $query = "where idfuncionario = ".$pesquisa;
       break;
       default: $query = "";
       break;
     }
     $statement = $this->conexao->query("select * from funcionario {$query}");
     return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
   }catch(PDOException $error){
     echo "Erro ao gerar JSON! ".$error;
   }
 }
}
