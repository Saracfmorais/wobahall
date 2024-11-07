<?php
// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wobahall';
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Capturar os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Inserir no banco de dados
$sql = "INSERT INTO usuarios (USU_VAR_NOME, USU_VAR_EMAIL, USU_VAR_SENHA) VALUES ('$nome', '$email', '$senha')";

if ($conn->query($sql) === TRUE) {
    echo "Usuário cadastrado com sucesso!";
    // Redirecionar para a página de login
    header("Location: login.php");
    exit();
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();
?>
