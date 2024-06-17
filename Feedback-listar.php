<?php
// Inclui o arquivo que contém a classe Feedback
require_once "Feedback.php";

// Inclui conexão com o banco de dados
require_once "conexao-banco.php";

// Função para importar comentários de um arquivo JSON
function importarComentarios($nomeArquivo)
{
    global $conexao;

    try {
        // Verifica se o arquivo existe
        if (!file_exists($nomeArquivo)) {
            throw new Exception("Arquivo JSON não encontrado.");
        }

        // Lê o conteúdo do arquivo JSON
        $json = file_get_contents($nomeArquivo);

        // Decodifica o JSON para um array associativo
        $comentarios = json_decode($json, true);

        // Prepara a instrução SQL para inserção
        $sql = "INSERT INTO tb_feedback (texto) VALUES (:texto)";
        $stmt = $conexao->prepare($sql);

        // Percorre os comentários e insere no banco de dados
        foreach ($comentarios as $comentario) {
            $texto = $comentario['comentario']; // Ajuste conforme estrutura do JSON

            // Executa a inserção com prepared statement
            $stmt->bindParam(':texto', $texto);
            $stmt->execute();
        }

        echo "Comentários importados com sucesso.";
    } catch (Exception $e) {
        echo "Erro ao importar comentários: " . $e->getMessage();
    }
}

// Cria um novo objeto Feedback, passando a conexão como parâmetro
$feedback = new Feedback($conexao);

// Verifica se a requisição para excluir foi feita
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $feedback->excluir($id);
}

// Verifica se a requisição para importar foi feita
if (isset($_POST['importar'])) {
    $nomeArquivo = $_FILES['arquivo']['tmp_name'];
    importarComentarios($nomeArquivo);
}

// Chama o método "listar" e armazena o resultado em uma variável
$lista = $feedback->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Feedback</title>
    <link rel="stylesheet" href="feedback.css"> <!-- Utilizando o mesmo CSS -->
</head>
<body class="fundo-login">
    <div>
        <div class="texto-login-titulo">
            <h1>Sistema de Feedback</h1>
        </div>
        <div class="texto-login">
            <div class="form-container">
                <h3>Listar feedbacks</h3>
                <table border="1">
                    <tr>
                        <th>Comentário</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($lista as $linha): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($linha['texto']); ?></td>
                        <td><a class="btn-excluir" href="?excluir=<?php echo $linha['id']; ?>">Excluir</a></td>
                    </tr>
                    <?php endforeach ?>
                </table>
                <br>
                <!-- Botão para importar comentários -->
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="arquivo">Importar Comentários:</label>
                    <input type="file" name="arquivo" id="arquivo" accept=".json">
                    <button type="submit" name="importar">Importar</button>
                </form>
            <
