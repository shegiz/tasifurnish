<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();
$projects = get_projects();
$categories = get_categories();

include __DIR__ . '/../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Portfóliónk</h1>
        <p class="section-intro">Böngésszen egyedi bútorprojektjeink gyűjteményében. Minden darab egyedileg készül, hogy megfeleljen ügyfeleink specifikus igényeinek és stíluspreferenciáinak.</p>
        
        <div class="filter-buttons">
            <button class="filter-btn active" data-category="all">Összes projekt</button>
            <?php foreach ($categories as $category): ?>
            <button class="filter-btn" data-category="<?php echo e($category); ?>"><?php echo format_project_type($category); ?></button>
            <?php endforeach; ?>
        </div>
        
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
            <a href="/project.php?slug=<?php echo e($project['slug']); ?>" class="project-card" data-category="<?php echo e($project['category']); ?>">
                <img src="/assets/img/<?php echo e($project['images'][0]); ?>" alt="<?php echo e($project['title']); ?>" class="project-card-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'250\'%3E%3Crect fill=\'%23E8E0D6\' width=\'400\' height=\'250\'/%3E%3Ctext fill=\'%235C4A3A\' font-family=\'sans-serif\' font-size=\'16\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dominant-baseline=\'middle\'%3E<?php echo e($project['title']); ?>%3C/text%3E%3C/svg%3E';">
                <div class="project-card-content">
                    <span class="category"><?php echo format_project_type($project['category']); ?></span>
                    <h3><?php echo e($project['title']); ?></h3>
                    <p class="short"><?php echo e($project['short']); ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-strip">
    <div class="container">
        <h2>Van projekt ötlete?</h2>
        <p>Beszéljük meg, hogyan valósíthatjuk meg az Ön elképzelését.</p>
        <div class="mt-lg">
            <a href="/contact.php" class="btn btn-secondary">Ajánlatkérés</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
