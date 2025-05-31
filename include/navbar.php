<?php
$currentUserType = getUserType();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="../dashboard.php">Sistem Login</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Dashboard</a>
                </li>

                <?php if ($currentUserType === 'admin' || $currentUserType === 'it'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown">
                            Admin Menu
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../admin/dashboard.php">Admin Dashboard</a></li>
                            <?php if ($currentUserType === 'it'): ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../it/dashboard.php">IT Dashboard</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                        <span class="badge <?=
                            $currentUserType === 'it' ? 'bg-danger' :
                            ($currentUserType === 'admin' ? 'bg-success' : 'bg-primary')
                            ?> ms-1">
                            <?= $currentUserType ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../login/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>