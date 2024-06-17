<?php
// Inclua a conexão com o banco de dados
require __DIR__ . '/conexao-banco.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se todos os campos foram preenchidos
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        // Recupere os valores do formulário
        $email = $_POST['email'];
        $password = $_POST['senha'];

        try {
            // Prepare a instrução SQL para seleção
            $sql = "SELECT * FROM tb_usuarios WHERE email = :email";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Verifique se o usuário existe
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifique a senha
                if ($password == $usuario['senha']) { // Comparação sem hash
                    // Defina a sessão do usuário
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nome'] = $usuario['nome'];
                    
                    // Verifique o tipo de usuário e redirecione conforme necessário
                    if ($usuario['tipo_usuario'] == 1) {
                        // Tipo de usuário é 1 (normal), redirecionar para Feedback.html
                        header("Location: Feedback.html");
                        exit;
                    } elseif ($usuario['tipo_usuario'] == 2) {
                        // Tipo de usuário é 2 (administrador), redirecionar para Feedback-listar.php
                        header("Location: Feedback-listar.php");
                        exit;
                    } else {
                        // Tipo de usuário desconhecido
                        echo "Tipo de usuário desconhecido.";
                    }
                } else {
                    echo "Senha incorreta.";
                }
            } else {
                echo "Email não encontrado.";
            }
        } catch (PDOException $e) {
            echo "Erro ao fazer login: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
