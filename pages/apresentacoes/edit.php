<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$erro = '';

// Verifica ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Busca dados atuais
try {
    $stmt = $pdo->prepare("SELECT * FROM apresentacoes WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $apresentacao = $stmt->fetch();

    if (!$apresentacao) {
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

// Buscar eventos e palestrantes para os selects
$eventos = $pdo->query("SELECT id, titulo FROM eventos ORDER BY titulo ASC")->fetchAll();
$palestrantes = $pdo->query("SELECT id, nome FROM palestrantes ORDER BY nome ASC")->fetchAll();

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
            $stmt = $pdo->prepare("UPDATE apresentacoes SET titulo = :titulo, evento_id = :evento_id, palestrante_id = :palestrante_id, horario = :horario WHERE id = :id");
            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':evento_id', $evento_id, PDO::PARAM_INT);
            $stmt->bindValue(':palestrante_id', $palestrante_id, PDO::PARAM_INT);
            $stmt->bindValue(':horario', $horario);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header('Location: index.php?sucesso=' . urlencode('Apresentação atualizada com sucesso.'));
                exit;
            }
        } catch (PDOException $e) {
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Editar Apresentação</h1>
            <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                <?php endif; ?>

                <form action="edit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-bold">Título da Apresentação/Tema <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : htmlspecialchars($apresentacao['titulo']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="evento_id" class="form-label fw-bold">Evento <span class="text-danger">*</span></label>
                        <select class="form-select" id="evento_id" name="evento_id" required>
                            <option value="">Selecione o Evento</option>
                            <?php 
                            $sel_evento = isset($_POST['evento_id']) ? $_POST['evento_id'] : $apresentacao['evento_id'];
                            foreach ($eventos as $ev): 
                            ?>
                                <option value="<?php echo $ev['id']; ?>" <?php echo ($sel_evento == $ev['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ev['titulo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="palestrante_id" class="form-label fw-bold">Palestrante <span class="text-danger">*</span></label>
                        <select class="form-select" id="palestrante_id" name="palestrante_id" required>
                            <option value="">Selecione o Palestrante</option>
                            <?php 
                            $sel_pal = isset($_POST['palestrante_id']) ? $_POST['palestrante_id'] : $apresentacao['palestrante_id'];
                            foreach ($palestrantes as $pal): 
                            ?>
                                <option value="<?php echo $pal['id']; ?>" <?php echo ($sel_pal == $pal['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pal['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="horario" class="form-label fw-bold">Horário <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="horario" name="horario" value="<?php echo isset($_POST['horario']) ? htmlspecialchars($_POST['horario']) : htmlspecialchars($apresentacao['horario']); ?>" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Atualizar Apresentação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
