<?php
session_start(); // abrindo uma sessao
ini_set('default_charset','UTF-8'); 
require "conectar.php"; // mesma coisa que include ( conectar.php)
$login = $_POST['login']; // buscando o login digitado na memoria ram temporaria
$senha = $_POST['senha'];// buscando a senha digitado na memoria ram temporaria
$busca = mysqli_query($conexao, "SELECT * FROM cadastro WHERE '$login'=login"); // se isso for verdadeiro carrega array
$dados = mysqli_fetch_array($busca); // se encontrou acha o logn e a senha
$login_ok = $dados['login'];// vai carregar o login
$senha_ok = $dados['senha'];// vai carregar a senha
if($login==""){
echo "<script type='text/javascript'>alert('login Incorreto');</script>";
echo "<script>document.location.href='login.html';</script>"; // se estiver o login estiver incorreto, direciona para o inicio ( index.html)
}elseif ($login!=$login_ok){
echo "<script type='text/javascript'>alert('login Incorreto');</script>"; // mensagem de erro
echo "<script>document.location.href='login.html';</script>"; // direcionamento para o inicio
}elseif($senha!=$senha_ok){
echo "<script type='text/javascript'>alert('senha incorreta');</script>"; // se estiver a senha estiver incorreto, direciona para o inicio ( index.html)
echo " <script>document.location.href='login.html';</script>";// direcionamento para o inicio
}else{
$_SESSION['slogin']=$login_ok;
$_SESSION['ssenha']=$senha_ok;
echo "<script type='text/javascript'>alert('Logado com sucesso !!!');</script>";
echo "<script>document.location.href='admin.php';</script>";

}
?>