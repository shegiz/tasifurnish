<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();
$errors = [];
$success = false;
$form_data = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!csrf_validate($csrf_token)) {
        $errors['csrf'] = 'Érvénytelen biztonsági token. Kérjük, próbálja újra.';
    } else {
        // Check rate limiting
        if (!rate_limit_check(3, 10)) {
            $errors['rate_limit'] = 'Túl sok beküldési kísérlet. Kérjük, várjon néhány percet, mielőtt újra próbálkozna.';
        } else {
            // Validate form
            $validation = validate_contact_form($_POST);
            $errors = $validation['errors'];
            $form_data = $validation['data'];
            
            // If no errors, send email
            if (empty($errors)) {
                $email_sent = send_contact_email($form_data);
                if ($email_sent) {
                    $success = true;
                    $form_data = []; // Clear form on success
                } else {
                    // Email failed but logged to file
                    $success = true; // Still show success since it's logged
                    $form_data = [];
                }
            }
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<section class="section projects v2">
    <div class="container">
        <h1 class="section-title">Kapcsolat</h1>
        <p class="section-intro">Van egy projekt ötlete? Lépjen velünk kapcsolatba, és beszéljük meg, hogyan valósíthatjuk meg az Ön elképzelését.</p>
        
        <div class="contact-info">
            <div class="contact-info-grid">
                <div class="contact-info-item">
                    <h4>Telefon</h4>
                    <p><a href="tel:<?php echo e($company['phone']); ?>"><?php echo e($company['phone']); ?></a></p>
                </div>
                <div class="contact-info-item">
                    <h4>Email</h4>
                    <p><a href="mailto:<?php echo e($company['email']); ?>"><?php echo e($company['email']); ?></a></p>
                </div>
                <div class="contact-info-item">
                    <h4>Cím</h4>
                    <p>
                        <?php echo e($company['address']['postal']); ?> <?php echo e($company['address']['city']); ?> <?php echo e($company['address']['street']); ?>
                    </p>
                </div>
                <div class="contact-info-item">
                    <h4>Nyitvatartás</h4>
                    <p>
                        <?php echo e($company['hours']); ?>
                    </p>
                </div>
            </div>
        </div>
        
        <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>Köszönjük!</strong> Üzenete sikeresen elküldve. Hamarosan felvesszük Önnel a kapcsolatot.
        </div>
        <?php endif; ?>
        
        <?php if (!empty($errors['csrf']) || !empty($errors['rate_limit'])): ?>
        <div class="alert alert-error">
            <?php if (!empty($errors['csrf'])): ?>
                <strong>Hiba:</strong> <?php echo e($errors['csrf']); ?>
            <?php endif; ?>
            <?php if (!empty($errors['rate_limit'])): ?>
                <strong>Hiba:</strong> <?php echo e($errors['rate_limit']); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="/contact.php" class="contact-form" style="max-width: 700px; margin: 0 auto;">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <!-- Honeypot field (hidden from users) -->
            <div class="form-group">
                <label for="website" class="honeypot">Weboldal (hagyja üresen)</label>
                <input type="text" id="website" name="website" class="honeypot" tabindex="-1" autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="name">Név <span class="required">*</span></label>
                <input type="text" id="name" name="nev" required value="<?php echo e($form_data['nev'] ?? ''); ?>" class="<?php echo !empty($errors['nev']) ? 'error-input' : ''; ?>">
                <?php if (!empty($errors['nev'])): ?>
                    <span class="error"><?php echo e($errors['nev']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required value="<?php echo e($form_data['email'] ?? ''); ?>" class="<?php echo !empty($errors['email']) ? 'error-input' : ''; ?>">
                <?php if (!empty($errors['email'])): ?>
                    <span class="error"><?php echo e($errors['email']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="phone">Telefon</label>
                <input type="tel" id="phone" name="telefon" value="<?php echo e($form_data['telefon'] ?? ''); ?>" class="<?php echo !empty($errors['telefon']) ? 'error-input' : ''; ?>">
                <?php if (!empty($errors['telefon'])): ?>
                    <span class="error"><?php echo e($errors['telefon']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="project_tipus">Projekt típus <span class="required">*</span></label>
                <select id="project_tipus" name="project_tipus" required class="<?php echo !empty($errors['project_tipus']) ? 'error-input' : ''; ?>">
                    <option value="">Kérjük, válasszon...</option>
                    <option value="halo" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'halo') ? 'selected' : ''; ?>>Hálószoba</option>
                    <option value="konyha" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'konyha') ? 'selected' : ''; ?>>Konyha</option>
                    <option value="teljes" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'teljes') ? 'selected' : ''; ?>>Teljes enteriőr</option>
                    <option value="iroda" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'iroda') ? 'selected' : ''; ?>>Iroda</option>
                    <option value="tarolas" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'tarolas') ? 'selected' : ''; ?>>Tárolási megoldások</option>
                    <option value="lepcso" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'lepcso') ? 'selected' : ''; ?>>Lépcső</option>
                    <option value="egyeb" <?php echo (isset($form_data['project_tipus']) && $form_data['project_tipus'] === 'egyeb') ? 'selected' : ''; ?>>Egyéb</option>
                </select>
                <?php if (!empty($errors['project_tipus'])): ?>
                    <span class="error"><?php echo e($errors['project_tipus']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="uzenet">Üzenet <span class="required">*</span></label>
                <textarea id="uzenet" name="uzenet" required class="<?php echo !empty($errors['uzenet']) ? 'error-input' : ''; ?>"><?php echo e($form_data['uzenet'] ?? ''); ?></textarea>
                <?php if (!empty($errors['uzenet'])): ?>
                    <span class="error"><?php echo e($errors['uzenet']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="kapcsolat_tipusa">Előnyben részesített kapcsolattartási módszer</label>
                <select id="kapcsolat_tipusa" name="kapcsolat_tipusa" class="<?php echo !empty($errors['kapcsolat_tipusa']) ? 'error-input' : ''; ?>">
                    <option value="">Nincs preferencia</option>
                    <option value="email" <?php echo (isset($form_data['kapcsolat_tipusa']) && $form_data['kapcsolat_tipusa'] === 'email') ? 'selected' : ''; ?>>Email</option>
                    <option value="telefon" <?php echo (isset($form_data['kapcsolat_tipusa']) && $form_data['kapcsolat_tipusa'] === 'telefon') ? 'selected' : ''; ?>>Telefon</option>
                </select>
                <?php if (!empty($errors['kapcsolat_tipusa'])): ?>
                    <span class="error"><?php echo e($errors['kapcsolat_tipusa']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-large">Üzenet küldése</button>
            </div>
        </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
