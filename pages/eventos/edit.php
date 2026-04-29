<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

$erro = '';

// Verifica se tem ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Busca dados atuais do evento
try {
    $stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $evento = $stmt->fetch();

    if (!$evento) {
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e Validação
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $data = $_POST['data'];
    $local = trim($_POST['local']);

    if (empty($titulo) || empty($data) || empty($local)) {
        $erro = 'Título, Data e Local são campos obrigatórios.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE eventos SET titulo = :titulo, descricao = :descricao, data = :data, local = :local WHERE id = :id");
            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':data', $data);
            $stmt->bindValue(':local', $local);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header('Location: index.php?sucesso=' . urlencode('Evento atualizado com sucesso.'));
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
            <h1 class="page-title mb-0">Editar Evento</h1>
            <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                <?php endif; ?>

                <form action="edit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-bold">Título do Evento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : htmlspecialchars($evento['titulo']); ?>" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="data" class="form-label fw-bold">Data <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="data" name="data" value="<?php echo isset($_POST['data']) ? htmlspecialchars($_POST['data']) : htmlspecialchars($evento['data']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="local" class="form-label fw-bold">Local <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="local" name="local" value="<?php echo isset($_POST['local']) ? htmlspecialchars($_POST['local']) : htmlspecialchars($evento['local']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : htmlspecialchars($evento['descricao']); ?></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save"></i> Atualizar Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
