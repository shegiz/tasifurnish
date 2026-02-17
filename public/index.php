<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();
$projects = get_projects();
$testimonials = get_testimonials();

// Get featured projects (first 6)
$featured_projects = array_slice($projects, 0, 6);

// Get testimonials preview (first 3)
$testimonials_preview = array_slice($testimonials, 0, 3);

// Hero background images (all files starting with "index-top" in storage)
$hero_images = glob(__DIR__ . '/assets/img/index-top*.*');
sort($hero_images);

include __DIR__ . '/../includes/header.php';
?>

<section class="hero">
    <?php if (!empty($hero_images)): ?>
    <div class="hero-bg">
        <?php foreach ($hero_images as $index => $image_path): ?>
            <div class="hero-bg-slide<?php echo $index === 0 ? ' is-active' : ''; ?>" style="background-image: url('/assets/img/<?php echo basename($image_path); ?>');"></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="hero-card">
            <h1><?php echo e($company['name']); ?></h1>
            <p class="tagline"><?php echo e($company['tagline']); ?></p>
            <div class="hero-ctas">
                <a href="/contact.php" class="btn btn-secondary btn-large">Ajánlatkérés</a>
                <a href="/portfolio.php" class="btn btn-large">Munkáink</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Mit készítünk</h2>
        <p class="section-intro">Egyedi ebédlőasztaloktól a beépített tárolási megoldásokig, olyan bútorokat készítünk, amelyek időtlen dizájnt párosítanak kivételes minőséggel. Minden darab rendelésre készül, az Ön helyszínéhez és stílusához igazítva.</p>
        
        <div class="services-grid">
            <div class="service-card">
                <h3>Ebédlő</h3>
                <p>Egyedi asztalok, székek és oldalszekrények, amelyek összehozzák a családot az asztal körül.</p>
            </div>
            <div class="service-card">
                <h3>Hálószoba</h3>
                <p>Ágykeretek, gardróbok és éjjeliszekrények, kényelemre és tárolásra tervezve.</p>
            </div>
            <div class="service-card">
                <h3>Konyha</h3>
                <p>Szigetek, szekrények és vágódeszkák, amelyek funkcionalitást párosítanak szépséggel.</p>
            </div>
            <div class="service-card">
                <h3>Nappali</h3>
                <p>Médiakonzolok, dohányzóasztalok és polcok a tér szervezéséhez és fokozásához.</p>
            </div>
            <div class="service-card">
                <h3>Iroda</h3>
                <p>Íróasztalok, könyvespolcok és tárolási megoldások produktív munkaterületekhez.</p>
            </div>
            <div class="service-card">
                <h3>Tárolási megoldások</h3>
                <p>Egyedi beépített bútorok, gardróbok és tárolóbútorok az Ön igényeihez igazítva.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background-color: var(--color-white);">
    <div class="container">
        <h2 class="section-title">Munkafolyamatunk</h2>
        <p class="section-intro">Szorosan együttműködünk Önnel a koncepciótól a befejezésig, biztosítva, hogy minden részlet megfeleljen az Ön elképzelésének.</p>
        
        <div class="process-steps">
            <div class="process-step">
                <div class="process-step-number">1</div>
                <h3>Konzultáció</h3>
                <p>Megbeszéljük az Ön igényeit, terét, stíluspreferenciáit és költségvetését, hogy megértsük az Ön elképzelését.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">2</div>
                <h3>Tervezés</h3>
                <p>Részletes terveket és 3D rendereléseket készítünk jóváhagyására, mielőtt a kivitelezés elkezdődne.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">3</div>
                <h3>Kivitelezés</h3>
                <p>Képzett mesterembereink hagyományos technikákkal és prémium anyagokkal építik meg az Ön bútorát.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">4</div>
                <h3>Kiszerelés</h3>
                <p>Kiszereljük és beépítjük a bútorát, biztosítva, hogy minden tökéletes legyen és készen álljon a használatra.</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Kiemelt projektek</h2>
        <p class="section-intro">Fedezze fel néhány legutóbbi munkánkat, amelyek bemutatják a minőséget és a mesterségbeliséget, amit minden projektbe hozunk.</p>
        
        <div class="projects-grid">
            <?php foreach ($featured_projects as $project): ?>
            <a href="/project.php?slug=<?php echo e($project['slug']); ?>" class="project-card">
                <img src="/assets/img/<?php echo e($project['images'][0]); ?>" alt="<?php echo e($project['title']); ?>" class="project-card-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'250\'%3E%3Crect fill=\'%23E8E0D6\' width=\'400\' height=\'250\'/%3E%3Ctext fill=\'%235C4A3A\' font-family=\'sans-serif\' font-size=\'16\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dominant-baseline=\'middle\'%3E<?php echo e($project['title']); ?>%3C/text%3E%3C/svg%3E';">
                <div class="project-card-content">
                    <span class="category"><?php echo format_project_type($project['category']); ?></span>
                    <h3><?php echo e($project['title']); ?></h3>
                    <p class="short"><?php echo e($project['short']); ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-lg">
            <a href="/portfolio.php" class="btn">Összes projekt megtekintése</a>
        </div>
    </div>
</section>

<section class="section" style="background-color: var(--color-white);">
    <div class="container">
        <h2 class="section-title">Mit mondanak ügyfeleink</h2>
        <p class="section-intro">Büszkék vagyunk az ügyfeleinkkel kialakított kapcsolatokra és a munkánkba vetett bizalmukra.</p>
        
        <div class="testimonials-grid">
            <?php foreach ($testimonials_preview as $testimonial): ?>
            <div class="testimonial-card">
                <p class="testimonial-quote"><?php echo e($testimonial['quote']); ?></p>
                <div class="testimonial-author"><?php echo e($testimonial['name']); ?></div>
                <?php if (!empty($testimonial['location'])): ?>
                <div class="testimonial-location"><?php echo e($testimonial['location']); ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-lg">
            <a href="/references.php" class="btn">Több vélemény olvasása</a>
        </div>
    </div>
</section>

<section class="cta-strip">
    <div class="container">
        <h2>Készen áll a projekt megkezdésére?</h2>
        <p>Lépjen velünk kapcsolatba, hogy megbeszéljük egyedi bútorigényeit.</p>
        <p>
            <a href="tel:<?php echo e($company['phone']); ?>"><?php echo e($company['phone']); ?></a> | 
            <a href="mailto:<?php echo e($company['email']); ?>"><?php echo e($company['email']); ?></a>
        </p>
        <div class="mt-lg">
            <a href="/contact.php" class="btn btn-secondary">Kapcsolat</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
