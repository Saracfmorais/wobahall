<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Nome de usuário do MySQL
    $password = "";     // Senha do MySQL (neste caso, sem senha)
    $dbname = "wobahall";

    // Conecte ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Obtenha os dados do formulário
    $email = $_POST["email"];
    $password = $_POST["senha"]; // A senha deve ser verificada com a senha no banco de dados

    // Verifique as credenciais do usuário
    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // O usuário está autenticado com sucesso
        session_start();
        $_SESSION['logged_in'] = true;
        header("Location: ../oficial/index.hmtl");
        exit(); // Pode redirecionar o usuário para a página principal aqui
    } else {
        echo "Credenciais inválidas. Tente novamente.";
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>
