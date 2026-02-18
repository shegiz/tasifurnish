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
rsort($hero_images);

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
        <h2 class="section-title">Miker rendelhet tőlünk</h2>
        <p class="section-intro">Olyan bútorokat tervezünk és kivitelezünk, amelyek időtlen dizájnt párosítanak kivételes minőséggel. Minden darab rendelésre készül, az Ön stílusához és igényeihez igazítva.</p>
        
        <div class="services-grid">
            <div class="service-card">
                <h3>Enteriőrtervezés</h3>
                <p>Okos térkihasználás és professzionális tervezés, legyen szó akár egyetlen szobáról vagy a teljes házról.</p>
            </div>
            <div class="service-card">
                <h3>Hálószoba</h3>
                <p>Ágykeretek, gardróbok és éjjeliszekrények, kényelemre és tárolásra tervezve.</p>
            </div>
            <div class="service-card">
                <h3>Konyha</h3>
                <p>Funkcionális és esztétikus konyhabútorok kialakítása az Ön igényeire szabva.</p>
            </div>
            <div class="service-card">
                <h3>Lépcsők, korlátok</h3>
                <p>Egyedi lépcsők és biztonságos korlátok tervezése és kivitelezése, amik a tér és az otthon szerves részei lesznek.</p>
            </div>
            <div class="service-card">
                <h3>Iroda</h3>
                <p>Íróasztalok, könyvespolcok és tárolási megoldások produktív munkavégzéshez.</p>
            </div>
            <div class="service-card">
                <h3>Tárolási megoldások</h3>
                <p>Egyedi tervezésű gardrób megoldások, amelyek a hely előnyeit maximalizálják.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background-color: var(--color-white);">
    <div class="container">
        <h2 class="section-title">Munkafolyamatunk</h2>
        <p class="section-intro">Szorosan együttműködünk Önnel a koncepciótól a befejezésig. Segítünk, hogy a biztosan dönthessen: elemezzük Önnel a különböző anyagokat és a vasalatokban rejlő praktikákat. Felhívjuk figyelmét a leggyakrabban elkövetet buktatókra, amik elkerülésével sok bosszankodást és komoly összegeket takaríthat meg.</p>
        <div class="process-steps">
            <div class="process-step">
                <div class="process-step-number">1</div>
                <h3>Díjmentes konzultáció</h3>
                <p>Megbeszéljük és megértjük az Ön igényeit. Átbeszéljük a munkafolyamatokat, eljárásokat és árakat.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">2</div>
                <h3>Tervezés</h3>
                <p>Részletes műszaki tartalmat készítünk 3D látvány tervvel, anyag és szin mintákkal véglegesítve.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">3</div>
                <h3>Kivitelezés</h3>
                <p>Összeszokott asztalos csapat gondoskodik a megtertervezet formák és bútorok prémium anyagokból való elkészítéséről.</p>
            </div>
            <div class="process-step">
                <div class="process-step-number">4</div>
                <h3>Beépítés</h3>
                <p>Az elkészített bútorokat a helyszínen beépítjük, hogy minden tökéletesen a helyére kerüljün, készen a használatra.</p>
            </div>
        </div>
    </div>
</section>
<section class="separator"></section>
<section class="section projects">
    <div class="container">
        <h2 class="section-title">Kiemelt projektek</h2>
        <p class="section-intro">Fedezze fel néhány legutóbbi munkánkat, amelyek bemutatják a minőséget és a mesterségbeliséget, amit minden projektbe hozunk.</p>
        
        <div class="projects-grid">
            <?php foreach ($featured_projects as $project): ?>
            <a href="/project.php?slug=<?php echo e($project['slug']); ?>" class="project-card">
                <img src="/assets/img/munkak/<?php echo e($project['images'][0]); ?>" alt="<?php echo e($project['title']); ?>" class="project-card-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'250\'%3E%3Crect fill=\'%23E8E0D6\' width=\'400\' height=\'250\'/%3E%3Ctext fill=\'%235C4A3A\' font-family=\'sans-serif\' font-size=\'16\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dominant-baseline=\'middle\'%3E<?php echo e($project['title']); ?>%3C/text%3E%3C/svg%3E';">
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

<section class="cta-strip">
    <div class="container">
        <h2>Készen áll hogy megtegye az első lépést?</h2>
        <p>Lépjen velünk kapcsolatba, segítünk megvalósítani elképzeléseit.</p>
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
