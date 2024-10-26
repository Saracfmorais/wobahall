<?php
$servername = "localhost";
$username = "root";  // O nome de usuário padrão para o MySQL
$password = "";      // Não há senha no exemplo

// Conectando ao servidor MySQL
$conn = new mysqli($servername, $username, $password);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criando o banco de dados "wobahall"
$sql = "CREATE DATABASE wobahall";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados 'wobahall' criado com sucesso!";
} else {
    echo "Erro ao criar o banco de dados: " . $conn->error;
}

// Fechando a conexão
$conn->close();
?>