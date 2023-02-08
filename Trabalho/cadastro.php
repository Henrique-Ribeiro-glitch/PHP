<?php
session_start();
ob_start();

require_once "modelo/usuario.class.php";

?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cadastro De Funcionario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/ajax/lib/ajax.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>
  <body>

    <?php
      if(!isset($_SESSION['privateUser'])) {
        echo "<h2>Você não tem permissão para acessar essa página</h2>";
        echo "</body>";
        echo "</html>";
        die();
      }
    ?>

    <h1 class="jumbotron bg-primary">Cadastro De Funcionario</h1>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Sistema</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>

            <?php
            if(isset($_SESSION['privateUser'])) {
              $usuario = unserialize($_SESSION['privateUser']);
              if($usuario->tipo == "rh") {
            ?>

            <li class="nav-item">
              <a class="nav-link" href="buscar-funcionario.php">Consultar Funcionario(s) <span class="sr-only">(current)</span></a>
            </li>

            <?php
              }
            }
           ?>

           <?php
           if(isset($_SESSION['privateUser'])) {
             $usuario = unserialize($_SESSION['privateUser']);
             if($usuario->tipo == "adm") {
           ?>

           <li class="nav-item">
             <a class="nav-link" href="buscar-funcionario.php">Consultar Funcionario(s) <span class="sr-only">(current)</span></a>
           </li>

           <li class="nav-item">
             <a class="nav-link" href="cadastroDeFornecedor.php">Cadastrar Fornecedor <span class="sr-only"></span></a>
           </li>

           <li class="nav-item">
             <a class="nav-link" href="buscar-fornecedor.php">Consultar Fornecedor(es) <span class="sr-only">(current)</span></a>
           </li>

           <?php
             }
           }
           ?>

         </ul>
       </div>
     </nav>

     <?php
     if (isset($_SESSION['erros'])) {
       $erros = unserialize($_SESSION['erros']);

       foreach($erros as $erro) {
         echo "Erro! $erro";
       }
       unset($_SESSION['erros']);
       $post = unserialize($_SESSION['post']);
     }
     ob_flush();
     ?>

     <form nome="formulario" action="controle.php" method="post">
       <div class="form-group">
         <input type="text" name="nome" autofocus class="form-control" placeholder="Digite o nome" required pattern="^[\wÀ-ü ]{5,30}$" value="<?php echo $post['nome'] ?? ""; ?>">
       </div>

        <div class="form-control">
         <input type="text" name="sobrenome" placeholder="Digite o sobrenome" class="form-control" required pattern="^[\wÀ-ü ]{5,30}$" value="<?php echo $post['sobrenome'] ?? ""; ?>">
        </div class="form-control">

       <div class="form-control">
         <input type="number" name="numeroParaContato" placeholder="Digite o numero pra contato" class="form-control" required pattern="^[\d()-]{8,20}$" value="<?php echo $post['numeroParaContato'] ?? ""; ?>">
       </div>

       <div class="form-control">
         <input type="text" name="email" placeholder="Digite o e-mail" class="form-control" required pattern="^[\wÀ-ü@]{15,30}$" value="<?php echo $post['email'] ?? ""; ?>">
       </div>

       <div class="form-control">
         <input type="text" name="endereco" placeholder="Digite o endereco" class="form-control" required pattern="^[\wÀ-ü ]{8,30}$" value="<?php echo $post['endereco'] ?? ""; ?>">
       </div>

     <div class="form-control">
      <input type="number" name="idade" placeholder="Digite a idade" class="form-control" required pattern="^[\d]{2,3}$" value="<?php echo $post['idade'] ?? ""; ?>">
     </div>

     <div class="form-control">
      <input type="text" name="cargo" placeholder="Digite o cargo" class="form-control" required pattern="^[\wÀ-ü ]{5,20}$" value="<?php echo $post['cargo'] ?? ""; ?>">
     </div>

     <div class="form-control">
      <label>
        <input type="radio" required pattern="^(Masculino)$" name="sexo" value="Masculino" value="<?php echo $post['sexo'] ?? ""; ?>">Masculino
      </label>

      <label>
        <input type="radio" required pattern="^(Feminino)$" name="sexo" value="Feminino" value="<?php echo $post['sexo'] ?? ""; ?>">Feminino
      </label>
     </div>

     <div class="form-control">
       <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
     </div>
    </form>
  </body>
</html>
