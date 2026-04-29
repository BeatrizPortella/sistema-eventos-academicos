<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM palestrantes WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        header('Location: index.php?sucesso=' . urlencode('Palestrante excluído com sucesso.'));
    } catch (PDOException $e) {
        header('Location: index.php?erro=' . urlencode('Erro ao excluir palestrante.'));
    }
    exit;
} else {
    header('Location: index.php');
    exit;
}
