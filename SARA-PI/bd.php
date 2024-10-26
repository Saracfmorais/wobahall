<?php
// Configurações de conexão
$host = 'localhost';
$user = 'root';
$password = ''; // Altere se necessário

// Conexão com o MySQL
$conn = new mysqli($host, $user, $password);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criação do banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS wobahall";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados 'wobahall' criado com sucesso!";
} else {
    die("Erro ao criar banco de dados: " . $conn->error);
}

// Seleciona o banco de dados
$conn->select_db('wobahall');

// Criação da tabela de usuários (USU)
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    USU_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    USU_VAR_NOME VARCHAR(100) NOT NULL,
    USU_VAR_EMAIL VARCHAR(100) NOT NULL UNIQUE,
    USU_VAR_SENHA VARCHAR(255) NOT NULL,
    USU_VAR_FOTO VARCHAR(255),
    USU_DAT_CRIADO TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'usuarios': " . $conn->error);
}

// Criação da tabela de endereços (END)
$sql = "CREATE TABLE IF NOT EXISTS enderecos (
    END_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    END_VAR_RUA VARCHAR(100) NOT NULL,
    END_VAR_NUMERO VARCHAR(10) NOT NULL,
    END_VAR_BAIRRO VARCHAR(100) NOT NULL,
    END_VAR_CIDADE VARCHAR(100) NOT NULL,
    END_VAR_ESTADO VARCHAR(50) NOT NULL,
    END_VAR_COMPLEMENTO VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'enderecos' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'enderecos': " . $conn->error);
}

// Criação da tabela de chácaras (CHA)

$sql = "CREATE TABLE IF NOT EXISTS chacaras (
    CHA_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    CHA_INT_USUARIO_ID INT(11) NOT NULL,
    CHA_INT_ENDERECO_ID INT(11) NOT NULL,
    CHA_DEC_PRECO DECIMAL(10, 2) NOT NULL,
    CHA_INT_HOSPEDES INT NOT NULL,
    CHA_INT_QUARTOS INT NOT NULL,
    CHA_INT_BANHEIROS INT NOT NULL,
    CHA_TXT_INFO_ADICIONAIS TEXT,
    CHA_DEC_AVALIACAO_MEDIA DECIMAL(3, 2) DEFAULT 0,
    CHA_DEC_TAMANHO DECIMAL(10, 2), -- Adicionado o campo para o tamanho em m²
    CHA_VAR_CAPA VARCHAR(255),
    CHA_DAT_CRIADO TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CHA_INT_USUARIO_ID) REFERENCES usuarios(USU_INT_ID),
    FOREIGN KEY (CHA_INT_ENDERECO_ID) REFERENCES enderecos(END_INT_ID)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'chacaras' criada com sucesso!";
} else {
    die("Erro ao modificar a tabela 'chacaras': " . $conn->error);
}

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'chacaras' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'chacaras': " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS fotos_chacara (
    FOTO_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    FOTO_INT_CHA_ID INT(11) NOT NULL,
    FOTO_VAR_CAMINHO VARCHAR(255) NOT NULL,
    FOTO_VAR_TIPO ENUM('capa', 'ambiente') NOT NULL DEFAULT 'ambiente',
    FOREIGN KEY (FOTO_INT_CHA_ID) REFERENCES chacaras(CHA_INT_ID)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'fotos_chacara' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'fotos_chacara': " . $conn->error);
}

// Criação da tabela de avaliações (AVA)
$sql = "CREATE TABLE IF NOT EXISTS avaliacoes (
    AVA_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    AVA_INT_CHA_ID INT(11) NOT NULL,
    AVA_INT_USU_ID INT(11) NOT NULL,
    AVA_INT_NOTA INT NOT NULL CHECK (AVA_INT_NOTA >= 1 AND AVA_INT_NOTA <= 5),
    AVA_TXT_COMENTARIO TEXT,
    AVA_DAT_CRIADO TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AVA_INT_CHA_ID) REFERENCES chacaras(CHA_INT_ID),
    FOREIGN KEY (AVA_INT_USU_ID) REFERENCES usuarios(USU_INT_ID)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'avaliacoes' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'avaliacoes': " . $conn->error);
}

// Criação da tabela de comentários (COM)
$sql = "CREATE TABLE IF NOT EXISTS comentarios (
    COM_INT_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    COM_INT_CHA_ID INT(11) NOT NULL,
    COM_INT_USU_ID INT(11) NOT NULL,
    COM_TXT_COMENTARIO TEXT NOT NULL,
    COM_DAT_CRIADO TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (COM_INT_CHA_ID) REFERENCES chacaras(CHA_INT_ID),
    FOREIGN KEY (COM_INT_USU_ID) REFERENCES usuarios(USU_INT_ID)
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'comentarios' criada com sucesso!";
} else {
    die("Erro ao criar tabela 'comentarios': " . $conn->error);
}

// Fechamento da conexão
$conn->close();
?>
