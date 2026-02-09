<?php
/**
 * Helper Functions
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Escape output to prevent XSS
 */
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Load company configuration
 */
function get_company() {
    static $company = null;
    if ($company === null) {
        $company = require __DIR__ . '/../content/company.php';
    }
    return $company;
}

/**
 * Load all projects
 */
function get_projects() {
    static $projects = null;
    if ($projects === null) {
        $projects = require __DIR__ . '/../content/projects.php';
    }
    return $projects;
}

/**
 * Get project by slug
 */
function get_project_by_slug($slug) {
    $projects = get_projects();
    foreach ($projects as $project) {
        if ($project['slug'] === $slug) {
            return $project;
        }
    }
    return null;
}

/**
 * Get unique categories from projects
 */
function get_categories() {
    $projects = get_projects();
    $categories = [];
    foreach ($projects as $project) {
        if (!in_array($project['category'], $categories)) {
            $categories[] = $project['category'];
        }
    }
    sort($categories);
    return $categories;
}

/**
 * Load testimonials
 */
function get_testimonials() {
    static $testimonials = null;
    if ($testimonials === null) {
        $testimonials = require __DIR__ . '/../content/testimonials.php';
    }
    return $testimonials;
}

/**
 * Generate CSRF token
 */
function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function csrf_validate($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Rate limiting check
 * Returns true if submission is allowed, false if rate limited
 */
function rate_limit_check($max_attempts = 3, $window_minutes = 10) {
    $key = 'contact_form_attempts';
    $now = time();
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }
    
    // Remove old attempts outside the time window
    $_SESSION[$key] = array_filter($_SESSION[$key], function($timestamp) use ($now, $window_minutes) {
        return ($now - $timestamp) < ($window_minutes * 60);
    });
    
    // Check if limit exceeded
    if (count($_SESSION[$key]) >= $max_attempts) {
        return false;
    }
    
    // Add current attempt
    $_SESSION[$key][] = $now;
    return true;
}

/**
 * Validate contact form
 * Returns ['errors' => [], 'data' => []]
 */
function validate_contact_form($post) {
    $errors = [];
    $data = [];
    
    // Name (required)
    $name = trim($post['name'] ?? '');
    if (empty($name)) {
        $errors['name'] = 'A név kötelező.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'A névnek legalább 2 karakterből kell állnia.';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'A név nem lehet hosszabb 100 karakternél.';
    } else {
        $data['name'] = $name;
    }
    
    // Email (required)
    $email = trim($post['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = 'Az email cím kötelező.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Kérjük, adjon meg egy érvényes email címet.';
    } else {
        $data['email'] = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    
    // Phone (optional)
    $phone = trim($post['phone'] ?? '');
    if (!empty($phone)) {
        $phone = preg_replace('/[^0-9+\-\s()]/', '', $phone);
        if (strlen($phone) > 20) {
            $errors['phone'] = 'A telefonszám túl hosszú.';
        } else {
            $data['phone'] = $phone;
        }
    }
    
    // Project type (required)
    $project_type = trim($post['project_type'] ?? '');
    $valid_types = ['dining', 'bedroom', 'kitchen', 'living', 'office', 'storage', 'outdoor', 'children', 'other'];
    if (empty($project_type)) {
        $errors['project_type'] = 'Kérjük, válasszon projekt típust.';
    } elseif (!in_array($project_type, $valid_types)) {
        $errors['project_type'] = 'Érvénytelen projekt típus.';
    } else {
        $data['project_type'] = $project_type;
    }
    
    // Budget range (optional)
    $budget = trim($post['budget'] ?? '');
    if (!empty($budget)) {
        $valid_budgets = ['under-1000', '1000-3000', '3000-5000', '5000-10000', 'over-10000'];
        if (!in_array($budget, $valid_budgets)) {
            $errors['budget'] = 'Érvénytelen költségvetési tartomány.';
        } else {
            $data['budget'] = $budget;
        }
    }
    
    // Message (required)
    $message = trim($post['message'] ?? '');
    if (empty($message)) {
        $errors['message'] = 'Az üzenet kötelező.';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Az üzenetnek legalább 10 karakterből kell állnia.';
    } elseif (strlen($message) > 2000) {
        $errors['message'] = 'Az üzenet nem lehet hosszabb 2000 karakternél.';
    } else {
        $data['message'] = $message;
    }
    
    // Preferred contact method (optional)
    $contact_method = trim($post['contact_method'] ?? '');
    if (!empty($contact_method)) {
        $valid_methods = ['email', 'phone'];
        if (!in_array($contact_method, $valid_methods)) {
            $errors['contact_method'] = 'Érvénytelen kapcsolattartási módszer.';
        } else {
            $data['contact_method'] = $contact_method;
        }
    }
    
    // Honeypot check (must be empty)
    $honeypot = trim($post['website'] ?? '');
    if (!empty($honeypot)) {
        $errors['honeypot'] = 'Spam észlelve.';
    }
    
    return [
        'errors' => $errors,
        'data' => $data
    ];
}

/**
 * Send contact email
 * Returns true on success, false on failure
 */
function send_contact_email($data) {
    $company = get_company();
    $recipient = $company['contact_recipient_email'];
    
    // Build email subject
    $subject = 'Új kapcsolatfelvételi űrlap beküldés ' . e($company['name']) . ' részéről';
    
    // Build email body
    $body = "Új kapcsolatfelvételi űrlap beküldés:\n\n";
    $body .= "Név: " . e($data['name']) . "\n";
    $body .= "Email: " . e($data['email']) . "\n";
    if (!empty($data['phone'])) {
        $body .= "Telefon: " . e($data['phone']) . "\n";
    }
    $body .= "Projekt típus: " . e($data['project_type']) . "\n";
    if (!empty($data['budget'])) {
        $budget_labels = [
            'under-1000' => '€1,000 alatt',
            '1000-3000' => '€1,000 - €3,000',
            '3000-5000' => '€3,000 - €5,000',
            '5000-10000' => '€5,000 - €10,000',
            'over-10000' => '€10,000 felett'
        ];
        $body .= "Költségvetés: " . ($budget_labels[$data['budget']] ?? $data['budget']) . "\n";
    }
    if (!empty($data['contact_method'])) {
        $contact_method_labels = [
            'email' => 'Email',
            'phone' => 'Telefon'
        ];
        $body .= "Előnyben részesített kapcsolattartási módszer: " . ($contact_method_labels[$data['contact_method']] ?? $data['contact_method']) . "\n";
    }
    $body .= "\nÜzenet:\n" . e($data['message']) . "\n";
    
    // Email headers
    $headers = "From: " . e($data['email']) . "\r\n";
    $headers .= "Reply-To: " . e($data['email']) . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Attempt to send email
    $success = @mail($recipient, $subject, $body, $headers);
    
    // If mail fails, log to file
    if (!$success) {
        log_contact_submission($data);
    }
    
    return $success;
}

/**
 * Log contact submission to file (fallback when mail() fails)
 */
function log_contact_submission($data) {
    $log_file = __DIR__ . '/../storage/contact_submissions.log';
    $log_dir = dirname($log_file);
    
    // Ensure directory exists and is writable
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }
    
    $entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $data
    ];
    
    $log_line = json_encode($entry) . "\n";
    @file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
}

/**
 * Format project type for display
 */
function format_project_type($type) {
    $types = [
        'dining' => 'Ebédlő',
        'bedroom' => 'Hálószoba',
        'kitchen' => 'Konyha',
        'living' => 'Nappali',
        'office' => 'Iroda',
        'storage' => 'Tárolás',
        'outdoor' => 'Kültér',
        'children' => 'Gyermekbútor',
        'other' => 'Egyéb'
    ];
    return $types[$type] ?? ucfirst($type);
}
