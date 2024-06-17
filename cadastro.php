<?php
// Inclua a conexão com o banco de dados
require __DIR__ . '/conexao-banco.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se todos os campos foram preenchidos
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['confirma_senha'])) {
        // Recupere os valores do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Verifique se as senhas coincidem
        if ($senha !== $confirma_senha) {
            echo "Erro: As senhas não coincidem.";
            exit;
        }

        // Senha coincide, continue com o cadastro
        $tipo_usuario = 1; // Valor fixo

        try {
            // Prepare a instrução SQL para inserção
            $sql = "INSERT INTO tb_usuarios (nome, email, senha, tipo_usuario) VALUES (:nome, :email, :senha, :tipo_usuario)";
            $stmt = $conexao->prepare($sql);
            
            // Vincule os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);

            // Execute a instrução SQL
            $stmt->execute();

            echo "Usuário cadastrado com sucesso!";
            
            // Redireciona para a tela de login após o cadastro
            header("Location: login.html");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
