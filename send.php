<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = sanitize($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefone = sanitize($_POST['telefone']);
    $assunto = sanitize($_POST['assunto']);
    $mensagem = sanitize($_POST['mensagem']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ E-mail inválido.";
        exit;
    }

    $to = "lumendesarte.contato@gmail.com";
    $subject = "Formulário de Contato: $assunto";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = "Nome: $nome\n";
    $body .= "E-mail: $email\n";
    $body .= "Telefone: $telefone\n";
    $body .= "Assunto: $assunto\n";
    $body .= "Mensagem:\n$mensagem\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "✅ Mensagem enviada com sucesso!";
    } else {
        echo "❌ Erro ao enviar a mensagem. Tente novamente ou envie diretamente para lumendesarte.contato@gmail.com";
    }
} else {
    echo "❌ Acesso inválido.";
}
?>