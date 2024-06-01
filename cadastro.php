<?php
require_once "conectar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["txtNome"] ?? "";
    $email = $_POST["txtEmail"] ?? "";
    $senha = $_POST["txtSenha"] ?? "";
    $confirmacaoSenha = $_POST["txtConfirmacaoSenha"] ?? "";
    $cpf = $_POST["txtCPF"] ?? "";
    $dataNascimento = $_POST["txtDataNascimento"] ?? "";
    $telefone = $_POST["txtTelefone"] ?? "";
    $receberPromocoes = isset($_POST["flexCheckDefault"]) ? 1 : 0;
    $cep = $_POST["txtCEP"] ?? "";
    $numero = $_POST["txtNumero"] ?? "";
    $complemento = $_POST["txtComplemento"] ?? "";
    $referencia = $_POST["txtReferencia"] ?? "";

    $erros = [];


    if (empty($erros)) {

        $conexao->begin_transaction();

        try {

            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, cpf, data_nascimento, telefone, receber_promocoes) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nome, $email, $senhaCriptografada, $cpf, $dataNascimento, $telefone, $receberPromocoes);
            $stmt->execute();
            $usuarioId = $stmt->insert_id;

            $stmt = $conexao->prepare("INSERT INTO enderecos (usuario_id, cep, numero, complemento, referencia) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $usuarioId, $cep, $numero, $complemento, $referencia);
            $stmt->execute();

            $conexao->commit();

            header("Location: confirmarcadastro.html");
            exit();

        } catch (mysqli_sql_exception $e) {

            $conexao->rollback();

            echo "Erro ao cadastrar: " . $e->getMessage(); 
        }
    } else {
        foreach ($erros as $erro) {
            echo $erro . "<br>";
        }
    }
}

function validaCPF($cpf) {  }

$conexao->close(); 