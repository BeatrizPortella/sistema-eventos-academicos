<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$erro = '';

// Buscar eventos para o select
$stmtEventos = $pdo->query("SELECT id, titulo FROM eventos ORDER BY titulo ASC");
$eventos = $stmtEventos->fetchAll();

// Buscar palestrantes para o select
$stmtPalestrantes = $pdo->query("SELECT id, nome FROM palestrantes ORDER BY nome ASC");
$palestrantes = $stmtPalestrantes->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e Validação
    $titulo = trim($_POST['titulo']);
    $evento_id = $_POST['evento_id'];
    $palestrante_id = $_POST['palestrante_id'];
    $horario = $_POST['horario'];

    if (empty($titulo) || empty($evento_id) || empty($palestrante_id) || empty($horario)) {
        $erro = 'Todos os campos são obrigatórios.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO apresentacoes (titulo, evento_id, palestrante_id, horario) VALUES (:titulo, :evento_id, :palestrante_id, :horario)");
            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':evento_id', $evento_id, PDO::PARAM_INT);
            $stmt->bindValue(':palestrante_id', $palestrante_id, PDO::PARAM_INT);
            $stmt->bindValue(':horario', $horario);
            
            if ($stmt->execute()) {
                header('Location: index.php?sucesso=' . urlencode('Apresentação cadastrada com sucesso.'));
                exit;
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Nova Apresentação</h1>
            <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                <?php endif; ?>

                <form action="create.php" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-bold">Título da Apresentação/Tema <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="evento_id" class="form-label fw-bold">Evento <span class="text-danger">*</span></label>
                        <select class="form-select" id="evento_id" name="evento_id" required>
                            <option value="">Selecione o Evento</option>
                            <?php foreach ($eventos as $ev): ?>
                                <option value="<?php echo $ev['id']; ?>" <?php echo (isset($_POST['evento_id']) && $_POST['evento_id'] == $ev['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ev['titulo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="palestrante_id" class="form-label fw-bold">Palestrante <span class="text-danger">*</span></label>
                        <select class="form-select" id="palestrante_id" name="palestrante_id" required>
                            <option value="">Selecione o Palestrante</option>
                            <?php foreach ($palestrantes as $pal): ?>
                                <option value="<?php echo $pal['id']; ?>" <?php echo (isset($_POST['palestrante_id']) && $_POST['palestrante_id'] == $pal['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pal['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="horario" class="form-label fw-bold">Horário <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="horario" name="horario" value="<?php echo isset($_POST['horario']) ? htmlspecialchars($_POST['horario']) : ''; ?>" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Salvar Apresentação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
