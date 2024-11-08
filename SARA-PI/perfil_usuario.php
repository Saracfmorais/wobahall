<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wobahall';
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Carregar os dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT USU_VAR_NOME, USU_VAR_EMAIL, USU_VAR_FOTO FROM usuarios WHERE USU_INT_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Atualizar dados do usuário ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nova_senha = $_POST['nova_senha'] ?? null;

    // Atualizar foto de perfil (opcional)
    if (!empty($_FILES['foto']['name'])) {
        $foto_path = 'uploads/' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
    } else {
        $foto_path = $user['USU_VAR_FOTO'];
    }

    // Atualizar dados do usuário no banco de dados
    if ($nova_senha) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET USU_VAR_NOME = ?, USU_VAR_EMAIL = ?, USU_VAR_SENHA = ?, USU_VAR_FOTO = ? WHERE USU_INT_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $foto_path, $usuario_id);
    } else {
        $sql = "UPDATE usuarios SET USU_VAR_NOME = ?, USU_VAR_EMAIL = ?, USU_VAR_FOTO = ? WHERE USU_INT_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $foto_path, $usuario_id);
    }
    
    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";
        // Atualizar o nome na sessão
        $_SESSION['nome_usuario'] = $nome;
    } else {
        echo "Erro ao atualizar os dados.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
</head>
<body>
    <h1>Perfil do Usuário</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($user['USU_VAR_NOME']); ?>" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['USU_VAR_EMAIL']); ?>" required><br>

        <label>Nova Senha (deixe em branco para manter a senha atual):</label><br>
        <input type="password" name="nova_senha"><br>

        <label>Foto de Perfil:</label><br>
        <?php if (!empty($user['USU_VAR_FOTO'])): ?>
            <img src="<?php echo $user['USU_VAR_FOTO']; ?>" alt="Foto de perfil" style="width: 100px;"><br>
        <?php endif; ?>
        <input type="file" name="foto"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
