<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

// Buscar eventos
$stmt = $pdo->query("SELECT * FROM eventos ORDER BY data DESC");
$eventos = $stmt->fetchAll();

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Gerenciar Eventos</h1>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Novo Evento</a>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_GET['sucesso']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Título</th>
                        <th width="15%">Data</th>
                        <th width="30%">Local</th>
                        <th width="20%" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($eventos) > 0): ?>
                        <?php foreach ($eventos as $evento): ?>
                            <tr>
                                <td><?php echo $evento['id']; ?></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($evento['titulo']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($evento['data'])); ?></td>
                                <td><?php echo htmlspecialchars($evento['local']); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $evento['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="bi bi-pencil-square"></i> Editar</a>
                                    <form action="delete.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $evento['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Excluir"><i class="bi bi-trash"></i> Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum evento cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
