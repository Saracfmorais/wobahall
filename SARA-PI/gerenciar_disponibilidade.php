<?php
session_start();

// Verificar se o usuário é proprietário e está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'proprietario') {
    header("Location: ../login/login.php");
    exit();
}

// Conectar ao banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wobahall';
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Processar o formulário para definir disponibilidade ou indisponibilidade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chacara_id = $_POST['chacara_id'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $disponivel = isset($_POST['disponivel']) ? 1 : 0; // 1 para disponível, 0 para indisponível

    $sql = "INSERT INTO disponibilidade_chacara (CHA_INT_ID, DISP_DAT_INICIO, DISP_DAT_FIM, DISP_BOOL_DISPONIVEL) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $chacara_id, $data_inicio, $data_fim, $disponivel);
    $stmt->execute();
    echo "Período adicionado com sucesso!";
}

// Listar períodos de disponibilidade e indisponibilidade
$chacara_id = $_GET['chacara_id'];
$sql = "SELECT DISP_DAT_INICIO, DISP_DAT_FIM, DISP_BOOL_DISPONIVEL 
        FROM disponibilidade_chacara 
        WHERE CHA_INT_ID = ?
        ORDER BY DISP_DAT_INICIO";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chacara_id);
$stmt->execute();
$result = $stmt->get_result();

$periodos = [];
while ($row = $result->fetch_assoc()) {
    $periodos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Disponibilidade</title>
</head>
<body>
    <h1>Gerenciar Disponibilidade da Chácara</h1>
    
    <!-- Formulário para definir períodos -->
    <form method="POST" action="">
        <input type="hidden" name="chacara_id" value="<?php echo $chacara_id; ?>">
        
        <label>Data Início:</label>
        <input type="date" name="data_inicio" required><br>
        
        <label>Data Fim:</label>
        <input type="date" name="data_fim" required><br>
        
        <label>
            <input type="checkbox" name="disponivel" checked> Disponível (desmarque para bloquear)
        </label><br>
        
        <button type="submit">Adicionar Período</button>
    </form>

    <h2>Períodos de Disponibilidade</h2>
    <ul>
        <?php foreach ($periodos as $periodo): ?>
            <li>
                <?php echo date("d/m/Y", strtotime($periodo['DISP_DAT_INICIO'])); ?> 
                até <?php echo date("d/m/Y", strtotime($periodo['DISP_DAT_FIM'])); ?> - 
                <?php echo $periodo['DISP_BOOL_DISPONIVEL'] ? 'Disponível' : 'Indisponível'; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
