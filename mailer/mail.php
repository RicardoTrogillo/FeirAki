<?php
// Incluindo os arquivos principais manualmente
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Usando namespaces do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Exemplo com Gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nikolasalcantara321@gmail.com';
    $mail->Password   = 'qfli wqkn ebay xamh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Configurações do e-mail
    $mail->setFrom('nikolasalcantara1@gmail.com', 'Seu Nome');
    $mail->addAddress('ritamilena29@gmail.com', 'Destinatário');
    $mail->Subject = 'Teste de envio';
    $mail->Body    = 'Faça meu pix às 10:00AM';
    
    // Enviar o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
?>
