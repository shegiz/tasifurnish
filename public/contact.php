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

<section class="section">
    <div class="container">
        <h1 class="section-title">Kapcsolat</h1>
        <p class="section-intro">Van egy projekt ötlete? Lépjen velünk kapcsolatba, és beszéljük meg, hogyan valósíthatjuk meg az ön elképzelését.</p>
        
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
                <input type="text" id="name" name="name" required value="<?php echo e($form_data['name'] ?? ''); ?>" class="<?php echo !empty($errors['name']) ? 'error-input' : ''; ?>">
                <?php if (!empty($errors['name'])): ?>
                    <span class="error"><?php echo e($errors['name']); ?></span>
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
                <input type="tel" id="phone" name="phone" value="<?php echo e($form_data['phone'] ?? ''); ?>" class="<?php echo !empty($errors['phone']) ? 'error-input' : ''; ?>">
                <?php if (!empty($errors['phone'])): ?>
                    <span class="error"><?php echo e($errors['phone']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="project_type">Projekt típus <span class="required">*</span></label>
                <select id="project_type" name="project_type" required class="<?php echo !empty($errors['project_type']) ? 'error-input' : ''; ?>">
                    <option value="">Kérjük, válasszon...</option>
                    <option value="dining" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'dining') ? 'selected' : ''; ?>>Ebédlő</option>
                    <option value="bedroom" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'bedroom') ? 'selected' : ''; ?>>Hálószoba</option>
                    <option value="kitchen" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'kitchen') ? 'selected' : ''; ?>>Konyha</option>
                    <option value="living" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'living') ? 'selected' : ''; ?>>Nappali</option>
                    <option value="office" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'office') ? 'selected' : ''; ?>>Iroda</option>
                    <option value="storage" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'storage') ? 'selected' : ''; ?>>Tárolási megoldások</option>
                    <option value="outdoor" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'outdoor') ? 'selected' : ''; ?>>Kültér</option>
                    <option value="children" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'children') ? 'selected' : ''; ?>>Gyermekbútor</option>
                    <option value="other" <?php echo (isset($form_data['project_type']) && $form_data['project_type'] === 'other') ? 'selected' : ''; ?>>Egyéb</option>
                </select>
                <?php if (!empty($errors['project_type'])): ?>
                    <span class="error"><?php echo e($errors['project_type']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="message">Üzenet <span class="required">*</span></label>
                <textarea id="message" name="message" required class="<?php echo !empty($errors['message']) ? 'error-input' : ''; ?>"><?php echo e($form_data['message'] ?? ''); ?></textarea>
                <?php if (!empty($errors['message'])): ?>
                    <span class="error"><?php echo e($errors['message']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="contact_method">Előnyben részesített kapcsolattartási módszer</label>
                <select id="contact_method" name="contact_method" class="<?php echo !empty($errors['contact_method']) ? 'error-input' : ''; ?>">
                    <option value="">Nincs preferencia</option>
                    <option value="email" <?php echo (isset($form_data['contact_method']) && $form_data['contact_method'] === 'email') ? 'selected' : ''; ?>>Email</option>
                    <option value="phone" <?php echo (isset($form_data['contact_method']) && $form_data['contact_method'] === 'phone') ? 'selected' : ''; ?>>Telefon</option>
                </select>
                <?php if (!empty($errors['contact_method'])): ?>
                    <span class="error"><?php echo e($errors['contact_method']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-large">Üzenet küldése</button>
            </div>
        </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
