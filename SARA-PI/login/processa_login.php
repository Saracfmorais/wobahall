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

// Capturar os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Preparar e executar a consulta para buscar o usuário pelo email, usando prepared statements
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE USU_VAR_EMAIL = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verificar a senha
    if (password_verify($senha, $user['USU_VAR_SENHA'])) {
        // Armazenar o ID e o nome do usuário na sessão
        $_SESSION['usuario_id'] = $user['USU_INT_ID'];
        $_SESSION['nome_usuario'] = $user['USU_VAR_NOME']; // Salva o nome do usuário na sessão

        // Redirecionar para a página inicial
        header("Location: ../home.php");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

// Fechar a conexão
$conn->close();
?>
