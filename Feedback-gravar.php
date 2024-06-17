<?php
// Inclui o arquivo que contém a definição da classe Feedback
require_once "Feedback.php";

// Inclui a conexão com o banco de dados
require_once "conexao-banco.php";

// Cria um objeto Feedback passando a conexão como parâmetro
$feedback = new Feedback($conexao);

// Define a propriedade texto do objeto Feedback
if (isset($_POST['texto'])) {
    $feedback->texto = $_POST['texto'];
    // Insere o feedback no banco de dados
    $feedback->inserir();
} else {
    echo "Erro: o campo 'texto' não foi enviado.";
}
?>
