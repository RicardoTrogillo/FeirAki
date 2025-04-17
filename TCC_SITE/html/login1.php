<?php
session_start(); 
$host = "";
$username = "";
$password = "";
$dbname = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $conn->prepare("SELECT * FROM usuarios2 WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['nome_sindico'] = $user['nome_sindico'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: PgInicialFeirante.php");
            exit();
        } else {
            $erro = "Email ou senha inválidos.";
        }
    } catch (PDOException $e) {
        $erro = "Erro na conexão: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Tela de login</title>
</head>
<body>
    <header>
        <div class="container-login">
            <div class="img-box">
                <img src="../images/login_build.png" alt="">
            </div>
            <div class="conten-box">
                <div class="formbox">
                    <h2>Login</h2>
                    <?php if (isset($erro)): ?>
                        <p style="color: red;"><?php echo $erro; ?></p>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="input-box">
                            <span>Email</span>
                            <input type="email" name="email" placeholder="SeuEmail@" required>
                        </div>
                        <div class="input-box">
                            <span>Senha</span>
                            <input type="password" name="senha" placeholder="Sua senha" required>
                        </div>
                        <div class="remember">
                            <a href="#">Esqueceu a senha?</a>
                        </div> 
                        <div class="input-box">
                            <input type="submit" value="Entrar Condominio">
                        </div>
                        <div class="input-box">
                            <p>Não possui uma conta? <a href="../html/cadastro1.php">Inscreva-se</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
</body>
</html>