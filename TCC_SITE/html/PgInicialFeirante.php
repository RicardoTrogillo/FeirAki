<?php 
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login1.php");
    exit();
}


$usuario_id = $_SESSION['usuario_id'];
$nome_logado = $_SESSION['nome_sindico'];
$email_logado = $_SESSION['email'];

$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT p.post_id, p.nome_feira, p.nome_feirante, p.descricao, p.imagem, p.regiao, u.email
        FROM post p
        JOIN usuarios u ON p.usuario_id = u.usuario_id";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['autor_email'])) {
    $autor_email = filter_var($_POST['autor_email'], FILTER_VALIDATE_EMAIL);
    if (!$autor_email) {
        $erro = "E-mail inválido.";
    } else {
        $mensagem = "Olá, um novo cliente tem interesse em seu anuncio!";
        
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        require '../PHPMailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host       = '';
            $mail->SMTPAuth   = true;
            $mail->Username   = '';
            $mail->Password   = '';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($email_logado, $nome_logado);
            $mail->addAddress($autor_email);

            $mail->isHTML(true);
            $mail->Subject = 'FeirAki';
            $mail->Body = "<p>$mensagem</p>";

            if ($mail->send()) {
                $sucesso = "Mensagem enviada com sucesso para $autor_email.";
            } else {
                $erro = "Erro ao enviar mensagem. Verifique as configurações.";
            }
        } catch (Exception $e) {
            $erro = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pagina-inicial.css">
    <title>Página Inicial</title>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../images/LOGO_OFICIAL.png" alt="">
            <p id="logo-titulo">FeiraAki</p>
        </div>

        <p>Bem-vindo, <?php echo htmlspecialchars($nome_logado); ?>!</p><a href="logout.php" style="color: red;">Sair</a>
   
    </nav>


    <section id="posts">
        <h4>Anunciados recentemente</h4>
        <div class="cards">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card1">

                    

                        <div class="image">
                            <?php if (!empty($row['imagem']) && file_exists($row['imagem'])): ?>
                                <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem do post">
                            <?php endif; ?>
                        </div>
                        <div class="conteudo">
                            <div class="principal">
                                <h3><?php echo htmlspecialchars($row['nome_feira']); ?></h3>
                                <p><?php echo htmlspecialchars($row['nome_feirante']); ?></p>
                                <p><?php echo htmlspecialchars($row['regiao']); ?></p>
                            </div>
                            <div class="text">
                                <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                            </div>
                        </div>
                        <div class="mensagem">
                            <form action="" method="POST">
                                <input type="hidden" name="autor_email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                <input type="submit" onclick="btn_alert()" value="Mensagem">
                                
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style=" font-size: 18px; font-weight: 400; display: flex;  align-items: center; justify-content: center; padding-top: 20px;">Não há posts ainda.</p>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function btn_alert(){

            Swal.fire({
                position: "center",
                icon: "success",
                title: "E-mail enviado com sucesso!",
                showConfirmButton: false,
                timer: 1500
                });     
            }
    </script>


     



</body>
</html>
