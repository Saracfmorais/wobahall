<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wobahall";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $name = $_POST["nome"];
    $email = $_POST["email"];
    $password = $_POST["senha"];

    $sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === true) {
        header("Location: login.html");
    } else {
        echo "Erro ao cadastrar o usuário: " . $conn->error;
    }
    
    // Feche a conexão com o banco de dados
    $conn->close();
}
?>