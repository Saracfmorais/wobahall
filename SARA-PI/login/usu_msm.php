<?php
// Informações de conexão com o banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$bancoDados = "wobahall";

// Conectar ao banco de dados
$conn = new mysqli($host, $usuario, $senha, $bancoDados);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Query para criar a tabela usuario
$query = "CREATE TABLE IF NOT EXISTS usuario (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            senha VARCHAR(255) NOT NULL
          )";

// Executar a query
if ($conn->query($query) === TRUE) {
    echo "Tabela 'usuario' criada com sucesso!";
} else {
    echo "Erro ao criar a tabela: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
