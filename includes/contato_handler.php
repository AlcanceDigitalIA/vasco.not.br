<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/csrf.php';

function processar_contato(): array {
    // Rate limiting por sessão
    if (!isset($_SESSION['form_count'])) $_SESSION['form_count'] = 0;
    if ($_SESSION['form_count'] >= RATE_LIMIT_MAX) {
        return ['ok' => false, 'msg' => 'Limite de envios atingido. Tente novamente mais tarde.'];
    }

    // Validar CSRF
    $token = $_POST[CSRF_TOKEN_NAME] ?? '';
    if (!csrf_validar($token)) {
        return ['ok' => false, 'msg' => 'Token inválido. Recarregue a página e tente novamente.'];
    }

    // Coletar e sanitizar
    $nome    = trim(strip_tags($_POST['nome']    ?? ''));
    $email   = trim(strip_tags($_POST['email']   ?? ''));
    $assunto = trim(strip_tags($_POST['assunto'] ?? ''));
    $mensagem = trim(strip_tags($_POST['mensagem'] ?? ''));

    // Validações
    if (strlen($nome) < 3)                          return ['ok' => false, 'msg' => 'Informe seu nome completo.'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['ok' => false, 'msg' => 'E-mail inválido.'];
    if (strlen($assunto) < 3)                       return ['ok' => false, 'msg' => 'Informe o assunto.'];
    if (strlen($mensagem) < 10)                     return ['ok' => false, 'msg' => 'Mensagem muito curta.'];

    // Proteção contra header injection
    if (preg_match('/[\r\n]/', $nome . $email . $assunto)) {
        return ['ok' => false, 'msg' => 'Dados inválidos.'];
    }

    $corpo  = "Nome: $nome\n";
    $corpo .= "E-mail: $email\n";
    $corpo .= "Assunto: $assunto\n\n";
    $corpo .= "Mensagem:\n$mensagem\n";

    $cabecalhos  = "From: noreply@vasco.not.br\r\n";
    $cabecalhos .= "Reply-To: $email\r\n";
    $cabecalhos .= "X-Mailer: PHP/" . phpversion();

    $enviado = mail(EMAIL_DESTINO, "[Site] $assunto", $corpo, $cabecalhos);

    if ($enviado) {
        $_SESSION['form_count']++;
        return ['ok' => true, 'msg' => 'Mensagem enviada com sucesso! Retornaremos em breve.'];
    }

    return ['ok' => false, 'msg' => 'Erro ao enviar. Entre em contato pelo telefone.'];
}
