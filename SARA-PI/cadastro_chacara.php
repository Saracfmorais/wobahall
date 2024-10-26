<!-- cadastro_chacara.php -->
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Chácara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, button, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de Chácara</h2>
       <!-- cadastro_chacara.php -->
        <form action="processa_cadastro_chacara.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="rua" placeholder="Rua" required>
            <input type="text" name="numero" placeholder="Número" required>
            <input type="text" name="bairro" placeholder="Bairro" required>
            <input type="text" name="cidade" placeholder="Cidade" required>
            <input type="text" name="estado" placeholder="Estado" required>
            <textarea name="info_adicionais" placeholder="Informações adicionais"></textarea>
            <input type="number" name="preco" placeholder="Preço" required>
            <input type="number" name="hospedes" placeholder="Número de hóspedes" required>
            <input type="number" name="quartos" placeholder="Número de quartos" required>
            <input type="number" name="banheiros" placeholder="Número de banheiros" required>
            <input type="number" name="tamanho" placeholder="Tamanho da área construída (m²)" step="0.01" required> <!-- Novo campo -->
            <label for="capa">Foto de Capa:</label>
            <input type="file" name="capa" required>
            <label for="ambiente">Fotos do Ambiente:</label>
            <input type="file" name="ambiente[]" multiple>
            <button type="submit">Cadastrar Chácara</button>
        </form>
    </div>
</body>
</html>
