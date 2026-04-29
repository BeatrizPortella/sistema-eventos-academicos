<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Buscar contadores para o dashboard
$cont_eventos = $pdo->query("SELECT count(*) FROM eventos")->fetchColumn();
$cont_palestrantes = $pdo->query("SELECT count(*) FROM palestrantes")->fetchColumn();
$cont_apresentacoes = $pdo->query("SELECT count(*) FROM apresentacoes")->fetchColumn();

// Próximos eventos
$stmt = $pdo->query("SELECT titulo, data, local FROM eventos WHERE data >= CURDATE() ORDER BY data ASC LIMIT 5");
$proximos_eventos = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h1 class="page-title">Dashboard Administrativo</h1>
<p class="text-muted">Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>. Visão geral do sistema.</p>

<div class="row mt-4">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title text-uppercase fw-bold opacity-75">Eventos</h6>
                    <h2 class="mb-0 fw-bold"><?php echo $cont_eventos; ?></h2>
                </div>
                <i class="bi bi-calendar-event fs-1 opacity-50"></i>
            </div>
            <a href="eventos/index.php" class="card-footer text-white text-decoration-none d-flex justify-content-between">
                Ver detalhes <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title text-uppercase fw-bold opacity-75">Palestrantes</h6>
                    <h2 class="mb-0 fw-bold"><?php echo $cont_palestrantes; ?></h2>
                </div>
                <i class="bi bi-person-badge fs-1 opacity-50"></i>
            </div>
            <a href="palestrantes/index.php" class="card-footer text-white text-decoration-none d-flex justify-content-between">
                Ver detalhes <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-title text-uppercase fw-bold opacity-75">Apresentações</h6>
                    <h2 class="mb-0 fw-bold"><?php echo $cont_apresentacoes; ?></h2>
                </div>
                <i class="bi bi-mic-fill fs-1 opacity-50"></i>
            </div>
            <a href="apresentacoes/index.php" class="card-footer text-dark text-decoration-none d-flex justify-content-between">
                Ver detalhes <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-calendar-week"></i> Próximos Eventos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Data</th>
                                <th>Local</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($proximos_eventos) > 0): ?>
                                <?php foreach ($proximos_eventos as $evento): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo htmlspecialchars($evento['titulo']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($evento['data'])); ?></td>
                                        <td><?php echo htmlspecialchars($evento['local']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Nenhum evento agendado para os próximos dias.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="eventos/index.php" class="btn btn-sm btn-outline-primary">Ver todos os eventos</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
