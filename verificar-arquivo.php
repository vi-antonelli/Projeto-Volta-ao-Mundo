<?php
// Exibir o conteúdo do diretório para verificar a presença do arquivo
$diretorio = __DIR__;
$arquivos = scandir($diretorio);

echo "Conteúdo do diretório: <br>";
foreach ($arquivos as $arquivo) {
    echo $arquivo . "<br>";
}

// Verificar a presença do arquivo 'conexao-banco.php'
$path = __DIR__ . '/conexao-banco.php';
if (file_exists($path)) {
    echo "Arquivo encontrado: " . $path;
} else {
    echo "Arquivo não encontrado: " . $path;
}
?>
