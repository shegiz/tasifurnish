<?php
require_once __DIR__ . '/../includes/functions.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: /portfolio.php');
    exit;
}

$project = get_project_by_slug($slug);

if (!$project) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . '/../includes/header.php';
    echo '<section class="section"><div class="container"><h1>Projekt nem található</h1><p>A keresett projekt nem létezik.</p><a href="/portfolio.php" class="btn">Vissza a portfólióhoz</a></div></section>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$company = get_company();
include __DIR__ . '/../includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="project-detail">
            <div class="project-detail-header">
                <h1><?php echo e($project['title']); ?></h1>
                <div class="project-detail-meta">
                    <span><strong>Kategória:</strong> <?php echo format_project_type($project['category']); ?></span>
                    <span><strong>Év:</strong> <?php echo e($project['year']); ?></span>
                    <?php if (!empty($project['location'])): ?>
                    <span><strong>Helyszín:</strong> <?php echo e($project['location']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="project-detail-images">
                <?php foreach ($project['images'] as $image): ?>
                    <div class="project-image-card">
                        <img src="/assets/img/munkak/<?php echo e($image); ?>" alt="<?php echo e($project['title']); ?>" class="project-detail-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'600\'%3E%3Crect fill=\'%23E8E0D6\' width=\'800\' height=\'600\'/%3E%3Ctext fill=\'%235C4A3A\' font-family=\'sans-serif\' font-size=\'20\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dominant-baseline=\'middle\'%3E<?php echo e($project['title']); ?>%3C/text%3E%3C/svg%3E';">
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="project-detail-content">
                <?php if (!empty($project['description'])): ?>
                    <h3>Erről a projektről</h3>
                    <p><?php echo nl2br(e($project['description'])); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-lg">
                <a href="/portfolio.php" class="btn">Vissza a portfólióhoz</a>
                <a href="/contact.php" class="btn">Hasonló projekt kérése</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
