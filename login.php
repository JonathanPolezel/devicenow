<?php
session_start(); // Inicia a sessão
require_once "conectar.php"; // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["txtEmail"] ?? "";
    $senha = $_POST["txtSenha"] ?? "";

    // Validações básicas (você pode adicionar mais validações aqui)
    $erros = [];
    if (empty($email)) {
        $erros[] = "O campo Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O Email informado é inválido.";
    }
    if (empty($senha)) {
        $erros[] = "O campo Senha é obrigatório.";
    }

    if (empty($erros)) {
        // Consulta o banco de dados para verificar as credenciais
        $stmt = $conexao->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();

            // Verifica a senha
            if (password_verify($senha, $usuario["senha"])) {
                // Login bem-sucedido
                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nome"] = $usuario["nome"];
                header("Location: cliente_pedidos.html"); // Redireciona após o login
                exit();
            } else {
                // Senha incorreta
                $erros[] = "Senha incorreta.";
            }
        } else {
            // Email não encontrado
            $erros[] = "Email não encontrado.";
        }
    }

    // Se houver erros, salva na sessão e redireciona
    if (!empty($erros)) {
        $_SESSION["erro_login"] = implode("<br>", $erros); // Junta os erros em uma string
        header("Location: login.php"); // Redireciona para a mesma página (login.php)
        exit();
    }
}

// Fecha a conexão
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
    <title>Device Now :: Página Principal</title>
</head>

<body>
    <div class="d-flex flex-column wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom shadow-sm mb-3">
            </nav>

        <main class="flex-fill">
            <div class="container">
                <div class="row justify-content-center">
                    <form class="col-sm-10 col-md-8 col-lg-6" method="POST" action=""> 
                        <h1>Identifique-se, por favor</h1>

                        <div class="form-floating mb-3">
                            <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder=" " autofocus>
                            <label for="txtEmail">E-mail</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder=" ">
                            <label for="txtSenha">Senha</label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" value="" id="chkLembrar" name="chkLembrar">
                            <label for="chkLembrar" class="form-check-label">Lembrar de mim</label>
                        </div>

                        <?php if (isset($_SESSION['erro_login'])): ?>
                            <div id="erroLogin" class="text-danger"><?php echo $_SESSION['erro_login']; ?></div>
                            <?php unset($_SESSION['erro_login']); // Remove a mensagem de erro da sessão ?>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-lg btn-dark">Entrar</button>

                        <p class="mt-3">
                            Ainda não é cadastrado? <a href="./cadastro.html" class="text-decoration-none text-dark">Clique aqui</a> para se cadastrar.
                        </p>

                        <p class="mt-3">
                            Esqueceu sua senha? <a href="./recuperarsenha.html" class="text-decoration-none text-dark">Clique aqui</a> para recuperá-la.
                        </p>
                    </form>
                </div>
            </div>
        </main>

        <footer class="border-top text-muted bg-light">
        </footer>
    </div>

    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
