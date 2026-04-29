<?php
session_start();
require_once 'config/database.php';

$termo_busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

try {
    if ($termo_busca) {
        // Busca eventos por nome (título) usando prepare statements (Sanitização)
        $stmt = $pdo->prepare("SELECT * FROM eventos WHERE titulo LIKE :busca ORDER BY data ASC");
        $stmt->bindValue(':busca', '%' . $termo_busca . '%');
        $stmt->execute();
    } else {
        // Lista todos os eventos
        $stmt = $pdo->query("SELECT * FROM eventos ORDER BY data ASC");
    }
    $eventos = $stmt->fetchAll();
} catch (PDOException $e) {
    $erro = "Erro ao buscar eventos: " . $e->getMessage();
}

require_once 'includes/header.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h1 class="page-title mb-0">Eventos Disponíveis</h1>
    </div>
    <div class="col-md-6">
        <form action="index.php" method="GET" class="d-flex">
            <input type="text" name="busca" class="form-control me-2" placeholder="Buscar eventos por nome..." value="<?php echo htmlspecialchars($termo_busca); ?>">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
            <?php if ($termo_busca): ?>
                <a href="index.php" class="btn btn-outline-secondary ms-2">Limpar</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
<?php endif; ?>

<div class="row">
    <?php if (count($eventos) > 0): ?>
        <?php foreach ($eventos as $evento): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <i class="bi bi-calendar-event"></i> <?php echo date('d/m/Y', strtotime($evento['data'])); ?>
                        </h6>
                        <p class="card-text mb-2">
                            <i class="bi bi-geo-alt-fill text-danger"></i> <?php echo htmlspecialchars($evento['local']); ?>
                        </p>
                        <p class="card-text text-truncate"><?php echo htmlspecialchars($evento['descricao']); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pb-3">
                        <button class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalEvento<?php echo $evento['id']; ?>">Ver Detalhes</button>
                    </div>
                </div>
            </div>

            <!-- Modal Detalhes Evento -->
            <div class="modal fade" id="modalEvento<?php echo $evento['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $evento['id']; ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabel<?php echo $evento['id']; ?>"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                        <strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['data'])); ?> | 
                        <strong>Local:</strong> <?php echo htmlspecialchars($evento['local']); ?>
                    </div>
                    <div class="mb-4">
                        <strong>Descrição:</strong>
                        <p class="mt-2"><?php echo nl2br(htmlspecialchars($evento['descricao'])); ?></p>
                    </div>
                    
                    <h6 class="border-bottom pb-2 mb-3"><i class="bi bi-mic-fill"></i> Apresentações deste Evento</h6>
                    <?php
                        // Buscar apresentações do evento
                        $stmtAp = $pdo->prepare("SELECT a.titulo, a.horario, p.nome as palestrante FROM apresentacoes a JOIN palestrantes p ON a.palestrante_id = p.id WHERE a.evento_id = :evento_id ORDER BY a.horario ASC");
                        $stmtAp->bindValue(':evento_id', $evento['id']);
                        $stmtAp->execute();
                        $apresentacoes = $stmtAp->fetchAll();
                    ?>
                    <?php if (count($apresentacoes) > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($apresentacoes as $ap): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><?php echo htmlspecialchars($ap['titulo']); ?></div>
                                        <small class="text-muted">Palestrante: <?php echo htmlspecialchars($ap['palestrante']); ?></small>
                                    </div>
                                    <span class="badge bg-secondary rounded-pill"><?php echo date('H:i', strtotime($ap['horario'])); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Nenhuma apresentação cadastrada para este evento ainda.</p>
                    <?php endif; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fim Modal -->

        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle-fill me-2"></i> Nenhum evento encontrado com os critérios de busca.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
