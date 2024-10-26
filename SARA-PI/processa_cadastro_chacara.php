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

$usuario_id = $_SESSION['usuario_id'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$preco = $_POST['preco'];
$hospedes = $_POST['hospedes'];
$quartos = $_POST['quartos'];
$banheiros = $_POST['banheiros'];
$info_adicionais = $_POST['info_adicionais'];

// Upload da imagem de capa
$capa_nome = $_FILES['capa']['name'];
$capa_tmp = $_FILES['capa']['tmp_name'];
$caminho_capa = "uploads/capa_" . time() . "_" . $capa_nome;
move_uploaded_file($capa_tmp, $caminho_capa);

// Inserir endereço
$sql = "INSERT INTO enderecos (END_VAR_RUA, END_VAR_NUMERO, END_VAR_BAIRRO, END_VAR_CIDADE, END_VAR_ESTADO) 
        VALUES ('$rua', '$numero', '$bairro', '$cidade', '$estado')";

if ($conn->query($sql) === TRUE) {
    $endereco_id = $conn->insert_id;

    // Inserir chácara com a foto de capa
    $sql = "INSERT INTO chacaras (CHA_INT_USUARIO_ID, CHA_INT_ENDERECO_ID, CHA_DEC_PRECO, CHA_INT_HOSPEDES, CHA_INT_QUARTOS, CHA_INT_BANHEIROS, CHA_TXT_INFO_ADICIONAIS, CHA_VAR_CAPA) 
            VALUES ('$usuario_id', '$endereco_id', '$preco', '$hospedes', '$quartos', '$banheiros', '$info_adicionais', '$caminho_capa')";

    if ($conn->query($sql) === TRUE) {
        $chacara_id = $conn->insert_id;

        // Upload das fotos do ambiente
        foreach ($_FILES['ambiente']['tmp_name'] as $key => $tmp_name) {
            $ambiente_nome = $_FILES['ambiente']['name'][$key];
            $caminho_ambiente = "uploads/ambiente_" . time() . "_" . $ambiente_nome;
            move_uploaded_file($tmp_name, $caminho_ambiente);

            // Inserir as fotos no banco de dados
            $sql = "INSERT INTO fotos_chacara (FOTO_INT_CHA_ID, FOTO_VAR_CAMINHO, FOTO_VAR_TIPO) 
                    VALUES ('$chacara_id', '$caminho_ambiente', 'ambiente')";
            $conn->query($sql);
        }

        echo "Chácara cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar a chácara: " . $conn->error;
    }
} else {
    echo "Erro ao cadastrar o endereço: " . $conn->error;
}

$conn->close();
?>
