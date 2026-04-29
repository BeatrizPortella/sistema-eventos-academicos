<?php
session_start();
require_once 'config/database.php';

// Se já estiver logado, redireciona para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: pages/dashboard.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch();

            if ($usuario) {
                // Para facilitar o desenvolvimento e testes com a senha em texto puro do SQL
                // Verificamos com password_verify (caso seja hash) ou igualdade simples (caso texto puro)
                if (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha']) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    
                    header('Location: pages/dashboard.php');
                    exit;
                } else {
                    $erro = 'Credenciais inválidas.';
                }
            } else {
                $erro = 'Credenciais inválidas.';
            }
        } catch (PDOException $e) {
            $erro = "Erro no sistema: " . $e->getMessage();
        }
    }
}

require_once 'includes/header.php';
?>

<div class="login-container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0"><i class="bi bi-person-circle"></i> Acesso Restrito</h4>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_GET['erro'])): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($_GET['erro']); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="senha" class="form-label fw-bold">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Entrar</button>
            </form>
        </div>
        <div class="card-footer text-center bg-light text-muted">
            <small>Apenas administradores podem acessar esta área.</small>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
