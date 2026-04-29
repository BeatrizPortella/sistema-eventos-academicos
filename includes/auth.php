<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /sistema-eventos/login.php?erro=' . urlencode('Acesso negado. Faça login para continuar.'));
    exit;
}
?>
