<?php
require_once '../../includes/auth.php';
require_once '../../config/database.php';

// Buscar apresentações com JOINS para pegar nomes do evento e palestrante
$query = "SELECT a.id, a.titulo, a.horario, e.titulo as evento, p.nome as palestrante 
          FROM apresentacoes a 
          JOIN eventos e ON a.evento_id = e.id 
          JOIN palestrantes p ON a.palestrante_id = p.id 
          ORDER BY e.data DESC, a.horario ASC";

$stmt = $pdo->query($query);
$apresentacoes = $stmt->fetchAll();

require_once '../../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Gerenciar Apresentações</h1>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Apresentação</a>
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
                        <th width="25%">Título da Apresentação</th>
                        <th width="25%">Evento</th>
                        <th width="20%">Palestrante</th>
                        <th width="15%">Horário</th>
                        <th width="15%" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($apresentacoes) > 0): ?>
                        <?php foreach ($apresentacoes as $ap): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($ap['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($ap['evento']); ?></td>
                                <td><?php echo htmlspecialchars($ap['palestrante']); ?></td>
                                <td><i class="bi bi-clock text-muted"></i> <?php echo date('H:i', strtotime($ap['horario'])); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?php echo $ap['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="bi bi-pencil-square"></i> Editar</a>
                                    <form action="delete.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $ap['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Excluir"><i class="bi bi-trash"></i> Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhuma apresentação cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
