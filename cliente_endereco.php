<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit();
}

require_once "conectar.php";

// Obtém o ID do usuário da sessão
$usuarioId = $_SESSION["usuario_id"];

// Consulta o endereço do usuário no banco de dados (assumindo que há apenas um endereço por usuário)
$stmt = $conexao->prepare("SELECT cep, numero, complemento, referencia FROM enderecos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o endereço foi encontrado
if ($result->num_rows == 1) {
    $endereco = $result->fetch_assoc();
} else {
    // Tratar caso o endereço não seja encontrado (redirecionar, exibir erro, etc.)
    die("Erro: Endereço não encontrado."); 
}

$conexao->close();
?>




<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="icon" type="image/png" sizes="64x64" href="./img/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/estilos.css">

    <title>Device Now :: Area Exclusiva</title>
</head>

<body>
    <div class="d-flex flex-column wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom shadow-sm mb-3">
            <div class="container">
                <img src="./img/favicon/2.png" height="60px" width="60px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target=".navbar-collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./index.html"><b>Principal</a></b>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./contato.html"><b>Contato</a></b>
                        </li>
                    </ul>
                    <div class="align-self-end">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="./cadastro.html" class="nav-link text-white"><b>Cadastre-se</a></b>
                            </li>
                            <li class="nav-item">
                                <a href="./login.html" class="nav-link text-white"><b>Entrar</a></b>
                            </li>
                            <li class="nav-item">
                                <span class="badge rounded-pill bg-light text-dark position-absolute ms-4 mt-0"
                                    title="5 produto(s) no carrinho"><small>5</small></span>
                                <a href="./carrinho.html" class="nav-link text-white">
                                    <i class="bi-cart" style="font-size:24px;line-height:24px;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

 
        <main class="flex-fill">
            <div class="container">
                <h1>Minha Conta</h1>
                <div class="row gx-3">
                    <div class="col-4">
                    <div class="list-group">
                            <a href="./cliente_dados.php" class="list-group-item list-group-item-action bg-dark text-light">
                                <i class="bi-person fs-6"></i> Dados Pessoais
                            </a>
                            <a href="./cliente_contatos.php" class="list-group-item list-group-item-action">
                                <i class="bi-mailbox fs-6"></i> Contatos
                            </a>
                            <a href="./cliente_endereco.php" class="list-group-item list-group-item-action">
                                <i class="bi-house-door fs-6"></i> Endereço
                            </a>
                            <a href="./cliente_pedidos.html" class="list-group-item list-group-item-action">
                                <i class="bi-truck fs-6"></i> Pedidos
                            </a>
                            <a href="./cliente_favoritos.html" class="list-group-item list-group-item-action">
                                <i class="bi-heart fs-6"></i> Favoritos
                            </a>
                            <a href="./cliente_senha.php" class="list-group-item list-group-item-action">
                                <i class="bi-lock fs-6"></i> Alterar Senha
                            </a>
                            <a href="./index.html" class="list-group-item list-group-item-action">
                                <i class="bi-door-open fs-6"></i> Sair
                            </a>
                        </div>
                    </div>
                    <div class="col-8">
                        <form action="">
                            <div class="form-floating mb-3 col-md-6 col-lg-4">
                                <input class="form-control" type="text" id="txtCEP" placeholder=" " value="<?php echo $endereco['cep']; ?>" autofocus />
                                <label for="txtCEP">CEP</label>
                            </div>
                            <div class="mb-3 col-md-6 col-lg-8">
                                <textarea class="form-control text-muted bg-light text" style="height: 58px; font-size: 14px;" 
                                          disabled>Digite o CEP para buscarmos o endereço.</textarea>
                            </div> 
                            <div class="form-floating mb-3 col-md-4">
                                <input class="form-control" type="text" id="txtNumero" placeholder=" " value="<?php echo $endereco['numero']; ?>" autofocus />
                                <label for="txtNumero">Número</label>
                            </div>
                            <div class="form-floating mb-3 col-md-8">
                                <input class="form-control" type="text" id="txtComplemento" placeholder=" " value="<?php echo $endereco['complemento']; ?>" autofocus />
                                <label for="txtComplemento">Complemento</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="txtReferencia" placeholder=" " value="<?php echo $endereco['referencia']; ?>" autofocus />
                                <label for="txtReferencia">Ponto de Referência</label>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-top text-muted bg-light">
            <div class="container">
                <div class="row py-3">
                    <div class="col-12 col-md-4 text-center">
                        &copy; 2023 - Device Now - Soluções e Tecnologia ME<br>
                        Avenida Nove de julho, 610 - Vila Cascatinha <br>
                        CPNJ 45.180.602/0001-06
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <a href="./privacidade.html" class="text-decoration-none text-dark">
                            Política de Privacidade
                        </a><br>
                        <a href="./termos.html" class="text-decoration-none text-dark">
                            Termos de Uso
                        </a><br>
                        <a href="./quemsomos.html" class="text-decoration-none text-dark">
                            Quem Somos
                        </a><br>
                        <a href="./trocas.html" class="text-decoration-none text-dark">
                            Trocas e Devoluções
                        </a>
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <a href="./contato.html" class="text-decoration-none text-dark">
                            Contato pelo Site
                        </a><br>
                        E-mail: <a href="mailto:contato@devicenow.com.br" class="text-decoration-none text-dark">
                            contato@devicenow.com.br
                        </a><br>
                        Telefone: <a href="phone:28999990000" class="text-decoration-none text-dark">
                            (13)97412-4438
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>