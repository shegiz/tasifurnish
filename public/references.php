<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();
$testimonials = get_testimonials();

include __DIR__ . '/../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Ügyfélreferenciák</h1>
        <p class="section-intro">Hálásak vagyunk az ügyfeleink által ránk bízott bizalomért. Íme, mit mondanak a <?php echo e($company['name']); ?>-val való együttműködésről.</p>
        
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-card">
                <p class="testimonial-quote"><?php echo e($testimonial['quote']); ?></p>
                <div class="testimonial-author"><?php echo e($testimonial['name']); ?></div>
                <?php if (!empty($testimonial['location'])): ?>
                <div class="testimonial-location"><?php echo e($testimonial['location']); ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="background-color: var(--color-white);">
    <div class="container">
        <h2 class="section-title">Bíznak bennünk</h2>
        <div class="logo-strip">
            <div class="logo-placeholder">Ügyfél logó</div>
            <div class="logo-placeholder">Ügyfél logó</div>
            <div class="logo-placeholder">Ügyfél logó</div>
            <div class="logo-placeholder">Ügyfél logó</div>
            <div class="logo-placeholder">Ügyfél logó</div>
        </div>
        <p class="text-center" style="color: var(--color-text-light); font-size: 0.875rem; margin-top: var(--spacing-md);">
            Cserélje le ezeket a helyőrzőket valós ügyfél logókkal. Adja hozzá a logó képeket a /public/assets/img/logos/ mappához és frissítse ezt a részt.
        </p>
    </div>
</section>

<section class="cta-strip">
    <div class="container">
        <h2>Készen áll, hogy csatlakozzon elégedett ügyfeleinkhez?</h2>
        <p>Lépjen velünk kapcsolatba, hogy megkezdje egyedi bútorprojektjét.</p>
        <div class="mt-lg">
            <a href="/contact.php" class="btn btn-secondary">Kapcsolat</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
