<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rubik Timer UAS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/rubik-timer/public/css/style.css">

    <script src="https://cdn.cubing.net/js/cubing/twisty" type="module"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            <i class="fas fa-cube fa-lg me-2"></i>CuberTimer
        </a>
        
        <div class="d-flex align-items-center">
            <?php if(isset($_SESSION['user_id'])): ?>
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?url=admin/index" class="btn btn-danger btn-sm rounded-pill px-3 me-3 fw-bold shadow-sm">
                        <i class="fas fa-user-shield me-1"></i> Admin Panel
                    </a>
                <?php endif; ?>

                <div class="d-none d-md-block me-3 text-end">
                    <small class="text-muted d-block" style="font-size: 0.7rem;">Signed in as</small>
                    <span class="fw-semibold text-dark"><?= $_SESSION['username'] ?></span>
                </div>
                <a href="index.php?url=auth/logout" class="btn btn-outline-danger rounded-pill px-4 btn-sm transition-hover">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container py-4">