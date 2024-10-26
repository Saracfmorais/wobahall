<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wobahall";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Lógica de autenticação aqui (melhorias sugeridas)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["senha"];

    // Lógica de autenticação usando declarações preparadas
    $query = "SELECT id, nome, email FROM usuario WHERE email=? AND senha=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obter informações do usuário
        $usuario = $result->fetch_assoc();

        // Iniciar a sessão (se já não estiver iniciada)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Armazenar informações do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

         // Aqui vc troca pra onde redireciona o login
        header("Location: ../oficial/index.html");
        exit();
    } else {
        // e aqui pra onde redireciona se der errado
        header("Location: log.php?erro=1");
        exit();
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
