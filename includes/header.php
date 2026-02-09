<?php
require_once __DIR__ . '/functions.php';
$company = get_company();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($company['tagline']); ?> - Egyedi bútorok <?php echo e($company['region']); ?>">
    <title><?php echo e($company['name']); ?> - <?php echo e($company['tagline']); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header class="site-header" id="site-header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">
                    <h1><?php echo e($company['name']); ?></h1>
                </a>
                <nav class="main-nav" id="main-nav" aria-label="Főmenü">
                    <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="main-nav">
                        <span class="sr-only">Menü</span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="nav-menu" id="nav-menu">
                        <li><a href="/" <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : ''); ?>>Kezdőlap</a></li>
                        <li><a href="/portfolio.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'portfolio.php' ? 'class="active"' : ''); ?>>Portfólió</a></li>
                        <li><a href="/references.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'references.php' ? 'class="active"' : ''); ?>>Referenciák</a></li>
                        <li><a href="/about.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'about.php' ? 'class="active"' : ''); ?>>Rólunk</a></li>
                        <li><a href="/contact.php" <?php echo (basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'class="active"' : ''); ?>>Kapcsolat</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main class="main-content">
