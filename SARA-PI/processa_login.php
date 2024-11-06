<?php
session_start();

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

// Capturar os dados do     formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Buscar o usuário no banco de dados
$sql = "SELECT * FROM usuarios WHERE USU_VAR_EMAIL = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($senha, $user['USU_VAR_SENHA'])) {
        $_SESSION['usuario_id'] = $user['USU_INT_ID'];
        header("Location: home.php");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$conn->close();
?>
