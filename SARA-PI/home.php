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

// Buscar cidades onde há chácaras
$cidades_query = "SELECT DISTINCT e.END_VAR_CIDADE FROM enderecos e JOIN chacaras c ON e.END_INT_ID = c.CHA_INT_ENDERECO_ID";
$cidades_result = $conn->query($cidades_query);
$cidades = [];
while ($row = $cidades_result->fetch_assoc()) {
    $cidades[] = $row['END_VAR_CIDADE'];
}

// Buscar capacidade máxima de hóspedes
$hospedes_query = "SELECT MAX(CHA_INT_HOSPEDES) as max_hospedes FROM chacaras";
$hospedes_result = $conn->query($hospedes_query);
$max_hospedes = $hospedes_result->fetch_assoc()['max_hospedes'] ?? 10; // valor padrão se não houver chácaras

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOBA Hall</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        
    </style>
</head>
<body>
    <header>
    <div class="logo">
    <img src="logo-wobahall.png" alt="WOBA Logo">
    <span>WOBA HALL</span>
</div>
<div class="nav-icons">
    <div class="nav-botao"><i class="fa-regular fa-heart"></i> Favoritos</div>
    <div class="nav-botao"><i class="fa-regular fa-user"></i>
        <?php if (isset($_SESSION['nome_usuario'])): ?>
            <?php echo $_SESSION['nome_usuario']; ?>
        <?php else: ?>
           <a class="logar" href="./login/login.php"> Logar
        <?php endif; ?>
    </div></a>         
</div>

    </header>
    <div class="progress-bar"></div>
    <!-- Barra de Pesquisa -->
    <section class="search-bar">
    <form class="search-form" action="resultados.php" method="GET">
        <div class="input-group">
            <label>Onde</label>
            <select name="cidade" class="search-input">
                <option value="">Selecione uma cidade</option>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?php echo $cidade; ?>"><?php echo $cidade; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-group b-yes">
            <label>Período Início</label>
            <input type="date" name="data_inicio" class="search-input">
        </div>
        <div class="input-group b-yes">
            <label>Período Fim</label>
            <input type="date" name="data_fim" class="search-input">
        </div>
        <div class="input-group b-yes">
            <label>Quem</label>
            <input type="number" name="hospedes" placeholder="Quantidade pessoas" class="search-input" min="1" max="<?php echo $max_hospedes; ?>">
        </div>
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</section>


    <!-- Texto CTI -->
    <section class="search-results">
        <h2>Encontre seu lugar ideal aqui!</h2>
    </section>

  <div class="linha-cards">  <!-- Cards de Lugares -->
    <section class="cards-section">
        
<?php include("chacara.php"); ?>                
        
        
    </section>
    
    </div>
    <div class="linha-cards">   
        <div class="bloco">            
            <div class="faixa-img">
                <div class="msg-card">
                    <img src="../SARA-PI/img/predinho.svg" alt="">
                        <h3>Busca rápida</h3>
                        <p>Busque opções entre mais de 5 milhões de hotéis em poucos segundos.</p>
                </div>
                <div class="msg-card">
                    <img src="../SARA-PI/img/oferta.svg" alt="">
                        <h3>Ótimas ofertas</h3>
                        <p>Encontre uma superoferta para reservar em sites parceiros.</p>
                </div>
                <div class="msg-card">
                    <img src="../SARA-PI/img/comparacao.svg" alt="">
                        <h3>Comparação abrangente</h3>
                        <p>Compare preços de hotéis de centenas de sites ao mesmo tempo.</p>
                </div>
            </div>
            <br><br>
            <div class="titulo">
                <h2>Lugares populares</h2>
            </div>
            <div class="lugares-faixa">
                <div class="lugares-card">
                    <img src="../SARA-PI/img/taubate.png" alt="Taubaté" class="lugares-imagem">
                    <div class="lugares-titulo">Taubaté</div>
                    <div class="lugares-chacaras">3.320 chácaras</div>
                    <div class="lugares-media">Méd.: <strong>R$ 220</strong></div>
                </div>
        
                <div class="lugares-card">
                    <img src="../SARA-PI/img/pinda.png" alt="Pindamonhangaba" class="lugares-imagem">
                    <div class="lugares-titulo">Pindamonhangaba</div>
                    <div class="lugares-chacaras">2.150 chácaras</div>
                    <div class="lugares-media">Méd.: <strong>R$ 250</strong></div>
                </div>
        
                <div class="lugares-card">
                    <img src="../SARA-PI/img/sjc.jpg" alt="São José dos Campos" class="lugares-imagem">
                    <div class="lugares-titulo">São José dos Campos</div>
                    <div class="lugares-chacaras">1.200 chácaras</div>
                    <div class="lugares-media">Méd.: <strong>R$ 300</strong></div>
                </div>
        
                <div class="lugares-card">
                    <img src="../SARA-PI/img/campos.png" alt="Campos do Jordão" class="lugares-imagem">
                    <div class="lugares-titulo">Campos do Jordão</div>
                    <div class="lugares-chacaras">850 chácaras</div>
                    <div class="lugares-media">Méd.: <strong>R$ 400</strong></div>
                </div>
            </div>

        </div>
</div>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo">WOBAHALL</div>
        <p class="footer-phrase">Encontre o lugar perfeito para criar memórias inesquecíveis.</p>
        <p class="footer-copyright">© 2024 WOBAHALL. Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>
        