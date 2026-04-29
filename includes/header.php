<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Defina a URL base do projeto para referenciar corretamente os assets e links
$base_url = '/sistema-eventos';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Eventos Acadêmicos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_url; ?>/index.php">
        <i class="bi bi-mortarboard-fill fs-4 me-2"></i>
        <span>Eventos Acadêmicos</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>/pages/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear"></i> Cadastros
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>/pages/eventos/index.php">Eventos</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>/pages/palestrantes/index.php">Palestrantes</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>/pages/apresentacoes/index.php">Apresentações</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <span class="nav-link text-white border-start ms-2 ps-3">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white ms-2 fw-bold" href="<?php echo $base_url; ?>/logout.php" title="Sair"><i class="bi bi-box-arrow-right"></i></a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-white me-3" href="<?php echo $base_url; ?>/index.php">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-area-restrita fw-bold" href="<?php echo $base_url; ?>/login.php">
                    <i class="bi bi-person-lock"></i> Área Restrita
                </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Container principal -->
<div class="container main-container">
