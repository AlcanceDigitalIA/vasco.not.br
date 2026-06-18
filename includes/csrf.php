<?php
function csrf_gerar(): string {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function csrf_validar(string $token): bool {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) return false;
    $valido = hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    // Regenera após uso
    unset($_SESSION[CSRF_TOKEN_NAME]);
    return $valido;
}
