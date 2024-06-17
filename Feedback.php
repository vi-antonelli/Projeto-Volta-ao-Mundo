<?php
class Feedback
{
    private $conexao;
    public $texto;

    // Construtor recebe a conexão como parâmetro
    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserir()
    {
        // Verifica se a conexão está disponível
        if (!$this->conexao) {
            throw new Exception("Conexão com o banco de dados não está disponível.");
        }

        $sql = "INSERT INTO tb_feedback (texto) VALUES (:texto)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->execute();

        echo "Registro enviado com sucesso";
        // Redireciona para a lista depois de 5 segundos
        header("refresh:1; URL=Feedback.html");
    }

    public function listar()
    {
        // Verifica se a conexão está disponível
        if (!$this->conexao) {
            throw new Exception("Conexão com o banco de dados não está disponível.");
        }

        $sql = "SELECT * FROM tb_feedback";
        $resultado = $this->conexao->query($sql);
        $lista = $resultado->fetchAll();

        return $lista;
    }

    public function excluir($id)
    {
        // Verifica se a conexão está disponível
        if (!$this->conexao) {
            throw new Exception("Conexão com o banco de dados não está disponível.");
        }

        $sql = "DELETE FROM tb_feedback WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Comentário excluído com sucesso.";
        // Redireciona para a lista após a exclusão
        header("Location: feedback-listar.php");
        exit;
    }
}
?>
