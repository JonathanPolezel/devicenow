<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php"); // Redireciona para login.php, não login.html
    exit();
}

require_once "conectar.php";

$usuarioId = $_SESSION["usuario_id"];
$erro = "";
$sucesso = "";

// Processar o formulário de atualização se enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os novos dados do formulário
    $novoEmail = $_POST["txtEmail"];
    $novoTelefone = $_POST["txtTelefone"];

    // Validações (adicione suas validações personalizadas aqui)
    if (empty($novoEmail) || empty($novoTelefone)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        $erro = "O Email informado é inválido.";
    } else {
        // Atualize os dados no banco de dados
        $stmt = $conexao->prepare("UPDATE usuarios SET email = ?, telefone = ? WHERE id = ?");
        $stmt->bind_param("ssi", $novoEmail, $novoTelefone, $usuarioId);
        if ($stmt->execute()) {
            $sucesso = "Dados atualizados com sucesso!";
        } else {
            $erro = "Erro ao atualizar os dados.";
        }
    }
}

// Consulta os dados do usuário
$stmt = $conexao->prepare("SELECT email, telefone FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$conexao->close();
?>


<!doctype html>
<html lang="pt-br">
<head>
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
                        <form method="POST" action="">
                            <div class="form-floating mb-3 col-md-8">
                                <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder=" " value="<?php echo $usuario['email']; ?>" autofocus/>
                                <label for="txtEmail">E-mail</label>
                            </div>
                            <div class="form-floating mb-3 col-md-6">
                                <input class="form-control" type="text" id="txtTelefone" name="txtTelefone" placeholder=" " value="<?php echo $usuario['telefone']; ?>"/>
                                <label for="txtTelefone">Telefone</label>
                            </div>   
                            <?php if (!empty($erro)): ?>
                                <div class="alert alert-danger"><?php echo $erro; ?></div>
                            <?php elseif (!empty($sucesso)): ?>
                                <div class="alert alert-success"><?php echo $sucesso; ?></div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-lg btn-primary">Salvar Alterações</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
