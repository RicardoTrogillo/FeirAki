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
    $nomeCondominio = $_POST['nome_condominio'];
    $nomeSindico = $_POST['nome_sindico'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $descricao = $_POST['descricao'];

    if (isset($_FILES['foto_condominio']) && $_FILES['foto_condominio']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['foto_condominio']['tmp_name'];
        $imagemNome = basename($_FILES['foto_condominio']['name']);
        $caminhoImagem = 'uploads/' . uniqid() . '_' . $imagemNome;

        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (!move_uploaded_file($imagemTmp, $caminhoImagem)) {
            $mensagem = "Erro ao mover o arquivo de imagem.";
            $caminhoImagem = null; 
        }
    } else {
        $mensagem = "Erro ao fazer upload da imagem: " . $_FILES['foto_condominio']['error'];
    }

    if (empty($mensagem)) {
       
        $sqlUsuario = "INSERT INTO usuarios2 (nome_condominio, nome_sindico, endereco, foto_condominio, email, senha, descricao) 
                       VALUES ('$nomeCondominio', '$nomeSindico', '$endereco', '$caminhoImagem', '$email', '$senha', '$descricao')";

        if ($conn->query($sqlUsuario) === TRUE) {
            $usuario_id = $conn->insert_id; 

            
            $sqlPost = "INSERT INTO post2 (usuario_id, nome_condominio, nome_sindico, endereco, foto_condominio, descricao) 
                        VALUES ('$usuario_id', '$nomeCondominio', '$nomeSindico', '$endereco', '$caminhoImagem', '$descricao')";

            if ($conn->query($sqlPost) === TRUE) {
                $mensagem = "Usuário e post cadastrados com sucesso!";
                header("Location: PgInicialFeirante.php");
                exit();
            } else {
                $mensagem = "Erro ao inserir no post2: " . $conn->error;
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
    <link rel="stylesheet" href="../css/cadastro1.css">
    <title>Tela de Cadastro Predio</title>
</head>
<body>

    <header>

        <div class="container-login">
            <div class="img-box">
                <img src="../images/DALL·E 2024-10-30 21.26.10 - A 3D-rendered green building in a cartoon style. The building should have soft edges, a playful and simple design with a green color scheme. No plants.webp" alt="">
            </div>

            <div class="conten-box">

                <div class="formbox">

                    <h2>Cadastro</h2>

                    <form method="POST" action="" enctype="multipart/form-data">

                        <div class="input-scroll">

                            <div class="input-box">
                                <span>Nome do Sindico</span>
                                <input type="text" name="nome_sindico" placeholder="Nome do Síndico" required>
                            </div>

                            <div class="input-box">
                                <span>Nome do Prédio</span>
                                <input type="text" name="nome_condominio" placeholder="Nome do Condomínio" required> 
                            </div>

                            <div class="input-box">
                                <span>Endereço</span>
                                <input type="text" name="endereco" placeholder="Endereço" required>
                            </div>

                            <div class="input-box">
                                <span>E-mail</span>
                                <input type="email" name="email" placeholder="Email" required>
                            </div>

                            <div class="input-box">
                                <span>Senha</span>
                                <input type="password" name="senha" placeholder="Senha" required>
                            </div>

                            <div class="input-box">
                                <span>Descrição</span>
                                <textarea name="descricao" placeholder="Descreva sobre a estrutura do prédio, o espaço livre, onde a feira será realizada, entre outros detalhes importantes de forma simples e direta. " required></textarea>
                            </div>

                            <div class="input-box">
                                    <span>Imagem</span>
                                    <input type="file" name="foto_condominio" accept="image/*" required> 
                            </div>

                        </div>
                        
                        <div class="remember">
                            <label>
                                <input type="checkbox"> <a href="">Aceitar os termos...  </a>                   
                            </label>
                        </div> 
                        <div class="input-box">
                            <input class="submit" type="submit" value="Cadastrar condominio">
                        </div>

                        <div class="input-box">
                            <p>Já tem uma conta?<a href="">Acesse</a></p>
                        </div>
                        

                    </form>

                </div>

            </div>

        </div>

    </header>
    
</body>
</html>