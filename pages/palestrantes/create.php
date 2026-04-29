<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e Validação
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $especialidade = trim($_POST['especialidade']);

    if (empty($nome) || empty($email)) {
        $erro = 'Nome e E-mail são campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO palestrantes (nome, email, especialidade) VALUES (:nome, :email, :especialidade)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':especialidade', $especialidade);
            
            if ($stmt->execute()) {
                header('Location: index.php?sucesso=' . urlencode('Palestrante cadastrado com sucesso.'));
                exit;
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) { // Erro de entrada duplicada MySQL
                $erro = "Este e-mail já está cadastrado para outro palestrante.";
            } else {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
            }
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Novo Palestrante</h1>
            <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                <?php endif; ?>

                <form action="create.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="especialidade" class="form-label fw-bold">Especialidade</label>
                        <input type="text" class="form-control" id="especialidade" name="especialidade" value="<?php echo isset($_POST['especialidade']) ? htmlspecialchars($_POST['especialidade']) : ''; ?>" placeholder="Ex: Inteligência Artificial, Engenharia de Software">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Salvar Palestrante</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
