    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo e($company['name']); ?></h3>
                    <p><?php echo e($company['tagline']); ?></p>
                </div>
                <div class="footer-section">
                    <h4>Gyors linkek</h4>
                    <ul>
                        <li><a href="/">Kezdőlap</a></li>
                        <li><a href="/portfolio.php">Portfólió</a></li>
                        <li><a href="/about.php">Rólunk</a></li>
                        <li><a href="/contact.php">Kapcsolat</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kapcsolat</h4>
                    <p>
                        <a href="tel:<?php echo e($company['phone']); ?>"><?php echo e($company['phone']); ?></a><br>
                        <a href="mailto:<?php echo e($company['email']); ?>"><?php echo e($company['email']); ?></a><br>
                        <?php echo e($company['address']['street']); ?><br>
                        <?php echo e($company['address']['postal']); ?> <?php echo e($company['address']['city']); ?><br>
                        <?php echo e($company['address']['country']); ?>
                    </p>
                </div>
                <div class="footer-section">
                    <h4>Kövess minket</h4>
                    <ul class="social-links">
                        <?php if (!empty($company['social']['instagram'])): ?>
                        <li><a href="<?php echo e($company['social']['instagram']); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">Instagram</a></li>
                        <?php endif; ?>
                        <?php if (!empty($company['social']['facebook'])): ?>
                        <li><a href="<?php echo e($company['social']['facebook']); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">Facebook</a></li>
                        <?php endif; ?>
                        <?php if (!empty($company['social']['pinterest'])): ?>
                        <li><a href="<?php echo e($company['social']['pinterest']); ?>" target="_blank" rel="noopener noreferrer" aria-label="Pinterest">Pinterest</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo e($company['name']); ?>. Minden jog fenntartva.</p>
            </div>
        </div>
    </footer>
    <a href="/contact.php" class="floating-cta" aria-label="Ajánlatkérés">Ajánlatkérés</a>
    <script src="/assets/js/main.js"></script>
</body>
</html>
