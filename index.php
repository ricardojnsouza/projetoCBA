<?php
session_start();
// - 
include_once "assets/config.php";
include_once "assets/classes/conexao.php";
include_once "assets/funcoes.php";



$active = null;
$post   = array_change_key_case($_POST ?? [], CASE_LOWER);
$get    = array_change_key_case($_GET  ?? [], CASE_LOWER);

$active = $get['link'] ?? "";

// - carrega o parser correspondente ao formulário submetido.
if (count($post) > 0) {
  switch ($active) {
    case "acessar":
      include_once "acessar/parser.php";
      break;
    case "registrar":
      include_once "registrar/parser.php";
      break;
    case "recuperar":
      include_once "recuperar/parser.php";
      break;
    case "contato":
      include_once "contato/parser.php";
      break;
    case "recuperacao":
      include_once "recuperacao/parser.php";
      break;
  }
}

// - obtem o usuário logado a partir do token de sessão definido em funcoes.php -> login()
$token  = $_SESSION['auth_token'] ?? null;
$user = getUserByToken($token);

// - redireciona o usuário logado para a página principal após o login.
if (!empty($active) && !empty($user)) {
  switch ($active) {
    case "acessar":
    case "registrar":
      $active = "inicio";
      break;
  }
}

// - caso receba alguma ação por GET
if (isset($get['action'])) {
  switch ($get['action']) {
    case "logout":
      if (logout($token)) {
        $token = null;
        $user = null;
      }
      break;
  }
}

// -

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Café, Bar & Areia</title>
  <script src="assets/jquery/jquery-3.6.0.min.js"></script>

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  
  <script src="assets/jquery/plugins/jquery.mask.js"></script>
  
  <script src="assets/bootstrap-5.0.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="assets/bootstrap-5.0.1/css/bootstrap.min.css">
  
  <!--
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
</head>
<?php

?>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="?link=inicio">LOGO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
          if (($user['idusuario'] ?? 0) === 0) {
            print('<li class="nav-item"><a class="nav-link" data-name="acessar|registrar" href="?link=acessar">Acessar / Cadastrar</a></li>');
          }
          ?>
          <?php
            if (($user['idusuario'] ?? 0) > 0) {
              print('<li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Buscar
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?link=buscar&segmento=cafe">Cafeterias</a></li>
                        <li><a class="dropdown-item" href="?link=buscar&segmento=bar">Bares</a></li>
                        <li><a class="dropdown-item" href="?link=buscar&segmento=praia">Barracas</a></li>
                      </ul>
                    </li>');
            }
          ?>
          <?php
            if (($user['idusuario'] ?? 0) > 0) {
              print('<li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pedidos
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="pedidos_ativos">
                        <li><a class="nav-link text-nowrap">Nenhum pedido ativo</a></li>
                      </ul>
                    </li>');
            }
          ?>
          <li class="nav-item">
            <a class="nav-link" data-name="quem-somos" href="?link=quem-somos">Quem Somos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-name="contato" href="?link=contato">Contato</a>
          </li>
          <?php
            if (($user['idusuario'] ?? 0) > 0) {
              print('<li class="nav-item"><a class="nav-link" data-name="gestao" href="?link=gestao">Painel de Controle</a></li>');
            }
          ?>
        </ul>
        <?php
        if (($user['idusuario'] ?? 0) > 0) {
          print('<span class="navbar-text"><a class="nav-link" data-name="sair" href="#" data-bs-toggle="modal" data-bs-target="#logout-modal">Sair</a></span>');
        }
        ?>
      </div>
    </div>
  </nav>
  <content>
    <?php

    switch ($active) {
      case "acessar":
        include_once "acessar/formulario.php";
        break;
      case "registrar":
        include_once "registrar/formulario.php";
        break;
      case "recuperar":
        include_once "recuperar/formulario.php";
        break;
      case "quem-somos":
        include_once "sobre/quem-somos.php";
        break;
      case "contato":
        include_once "contato/formulario.php";
        break;
      case "buscar":
        include_once "buscar/formulario.php";
        break;
      case "gestao":
        include_once "gestao/gestao.php";
        break;
      case "pedido":
        include_once "pedido/verPedido.php";
        break;
      case "recuperacao":
        include_once "recuperacao/formulario.php";
        break;
      default:
        include_once "principal/home.php";
    }

    ?>
  </content>

  <!-- Modal: logout -->
  <div class="modal fade" id="logout-modal" tabindex="-1" aria-labelledby="logout-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logout-modal-label">Confirmação!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Deseja encerrar a sessão do CBA?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" data-action="logoff" class="btn btn-primary">Encerrar sessão</button>
        </div>
      </div>
    </div>
  </div>

  <script type='text/javascript'>
    document.addEventListener("DOMContentLoaded", function(event) {
      let content = document.querySelectorAll("content");

      // - adiciona a classe 'active' para a opção ativa no menu 'nav' | a variável '$active' é definida no switch logo acima onde é selecionada a página que incorpora o conteúdo do index.
      document.querySelectorAll(`nav a[data-name*='<?php print($active); ?>']`).forEach((link) => link.classList.add("active"));

      // - aciona as críticas listadas no PHP para serem exibidas como toasts..
      let criticas = <?php print(isset($criticas) && $criticas === true ? "true" : "false"); ?> || [];
      if (criticas) {
        // - carrega os toasts a partir do bootstrap!
        [].slice.call(document.querySelectorAll('.toast.criticas')).map((toastEl) => new bootstrap.Toast(toastEl)).forEach((toast) => toast.show());
      }

      // - aciona as críticas listadas no PHP para serem exibidas como toasts..
      let sucessos = <?php print(isset($sucessos) && $sucessos === true ? "true" : "false"); ?> || [];
      if (sucessos) {
        // - carrega os toasts a partir do bootstrap!
        [].slice.call(document.querySelectorAll('.toast.sucessos')).map((toastEl) => new bootstrap.Toast(toastEl)).forEach((toast) => toast.show());
      }

      // - registra a ação de logoff
      [].slice.call(document.querySelectorAll("button[data-action='logoff']")).forEach((button) => {
        button.onclick = function(event) {
          let href = window.location.href;
          if (href.lastIndexOf("?") >= 0) {
            href = href.substring(0, href.lastIndexOf("?"));
          }
          window.location.href = href + "?action=logout";
        };
      })
    });
  </script>

  <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
  <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>

  <?php
    if (($user['idusuario'] ?? 0) > 0) {
      require_once("pedido/appendIndex.php");
    }
  ?>

</body>

</html>