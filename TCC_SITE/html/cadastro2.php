<?php 
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$mensagem = '';
$caminhoImagem = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeOrganizador = $_POST['nome_organizador'];
    $nomeFeira = $_POST['nome_feira'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $descricao = $_POST['descricao'];
    $regiao = $_POST['regiao'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemNome = basename($_FILES['imagem']['name']);
        $caminhoImagem = 'uploads/' . uniqid() . '_' . $imagemNome;

        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (!move_uploaded_file($imagemTmp, $caminhoImagem)) {
            $mensagem = "Erro ao mover o arquivo de imagem.";
            $caminhoImagem = null;
        }
    }

    if (empty($mensagem)) {
        $sql = "INSERT INTO usuarios (nome_feirante, nome_feira, email, senha, descricao, imagem, regiao) 
                VALUES ('$nomeOrganizador', '$nomeFeira', '$email', '$senha', '$descricao', '$caminhoImagem', '$regiao')";

        if ($conn->query($sql) === TRUE) {
            $usuario_id = $conn->insert_id;
            $sqlPost = "INSERT INTO post (usuario_id, nome_feira, nome_feirante, descricao, imagem, regiao) 
                        VALUES ('$usuario_id', '$nomeFeira', '$nomeOrganizador', '$descricao', '$caminhoImagem', '$regiao')";

            if ($conn->query($sqlPost) === TRUE) {
                $mensagem = "Cadastro realizado com sucesso!";
                header("Location: PgInicialSindico.php");
                exit();
            } else {
                $mensagem = "Erro ao criar o post: " . $conn->error;
            }
        } else {
            $mensagem = "Erro ao cadastrar o usuário: " . $conn->error;
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
    <link rel="stylesheet" href="../css/cadastro2.css">
    <title>Tela de Cadastro Feira</title>
</head>
<body>
    <header>
        <div class="container-login">
            <div class="conten-box">
                <div class="formbox">
                    <h2>Cadastro</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="input-scroll">
                            <div class="input-box">
                                <span>Nome do Organizador</span>
                                <input type="text" name="nome_organizador" placeholder="Ex: Fernando da Silva" required>
                            </div>
                            <div class="input-box">
                                <span>Nome da Feira</span>
                                <input type="text" name="nome_feira" placeholder="Ex: Feira do Brás" required>
                            </div>
                            <div class="input-box">
                                <span>Região</span>
                                <input type="text" name="regiao" placeholder="Ex: Zona-Leste - ZL" required>
                            </div>
                            <div class="input-box">
                                <span>E-mail</span>
                                <input type="email" name="email" placeholder="SeuEmail@" required>
                            </div>
                            <div class="input-box">
                                <span>Senha</span>
                                <input type="password" name="senha" required>
                            </div>
                            <div class="input-box">
                                <span>Descrição</span>
                                <textarea name="descricao" rows="4" cols="40" placeholder="Fale sobre você e o que oferece na feira, explicando brevemente seu tipo de negócio, os produtos que vende e o que torna seu trabalho especial de forma atrativa." required></textarea>
                            </div>
                            <div class="input-box">
                                <span>Imagem</span>
                                <input type="file" name="imagem" accept="image/*" required>
                            </div>
                        </div>
                        <div class="remember">
                            <label>
                                <input type="checkbox" required> Aceitar os termos...
                            </label>
                        </div>
                        <div class="input-box">
                            <input class="submit" type="submit" value="Cadastrar Feirante">
                        </div>
                    </form>
                    <?php if ($mensagem): ?>
                        <p><?php echo $mensagem; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="img-box">
                <img src="../images/FEIRANTE.png" alt="">
            </div>
        </div>
    </header>
</body>
</html>
