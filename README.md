# Hinterholz Studio - Custom Furniture Website

A production-ready, multi-page marketing website for a carpenter/woodworker company built with vanilla PHP, HTML, CSS, and JavaScript.

## Features

- **Multi-page site** with clean navigation
- **Contact form** with server-side validation, CSRF protection, honeypot, and rate limiting
- **Portfolio** with filterable project grid and detail pages
- **Testimonials** page with client references
- **Mobile-first** responsive design
- **Accessible** semantic HTML with proper ARIA labels
- **Secure** with XSS prevention, input sanitization, and CSRF tokens
- **Easy to maintain** with centralized configuration and content files

## File Structure

```
/
├── public/                 # Public-facing files
│   ├── index.php          # Homepage
│   ├── portfolio.php      # Portfolio listing
│   ├── project.php        # Project detail pages
│   ├── references.php     # Testimonials page
│   ├── about.php          # About page
│   ├── contact.php        # Contact form page
│   └── assets/
│       ├── css/
│       │   └── styles.css # Main stylesheet
│       ├── js/
│       │   └── main.js    # JavaScript for filtering & nav
│       └── img/           # Project images
├── includes/              # Reusable PHP includes
│   ├── header.php         # Site header
│   ├── footer.php         # Site footer
│   └── functions.php      # Helper functions
├── content/               # Content configuration
│   ├── company.php        # Company info (single source of truth)
│   ├── projects.php       # Portfolio projects array
│   └── testimonials.php   # Testimonials array
├── storage/               # Storage directory
│   └── contact_submissions.log  # Fallback log for contact form
└── README.md              # This file
```

## Quick Start

### Local Development

1. **Start PHP built-in server:**
   ```bash
   php -S localhost:8000 -t public
   ```

2. **Open in browser:**
   ```
   http://localhost:8000
   ```

### Configuration

#### 1. Update Company Information

Edit `/content/company.php` to update:
- Company name, tagline, contact info
- Address and business hours
- Social media links
- **Important:** Set `contact_recipient_email` to your actual email address

#### 2. Add Projects

Edit `/content/projects.php` to add or modify projects. Each project needs:
- `slug` - URL-friendly identifier (e.g., "oak-dining-table")
- `title` - Project title
- `category` - One of: dining, bedroom, kitchen, living, office, storage, outdoor, children, other
- `short` - Short description for cards
- `description` - Full description for detail page
- `materials` - Materials used
- `year` - Year completed
- `location` - Optional location
- `images` - Array of image filenames

#### 3. Add Testimonials

Edit `/content/testimonials.php` to add or modify testimonials. Each testimonial needs:
- `name` - Client name
- `location` - Optional location
- `quote` - Testimonial text

#### 4. Add Project Images

1. Add your project images to `/public/assets/img/`
2. Name them according to the `images` array in `projects.php`
3. Recommended size: 800x600px or larger
4. Formats: JPG, PNG, or WebP

**Note:** The site includes SVG fallbacks for missing images, so it will work even without images initially.

#### 5. Storage Directory Permissions

Ensure the `/storage` directory is writable by the web server:

```bash
chmod 755 storage
chmod 666 storage/contact_submissions.log  # If file exists
```

Or create the log file:
```bash
touch storage/contact_submissions.log
chmod 666 storage/contact_submissions.log
```

## Email Configuration

### Using PHP `mail()` Function

The contact form uses PHP's `mail()` function by default. For local development:

**macOS (using Postfix):**
- Usually works out of the box
- Check `/etc/postfix/main.cf` if needed

**Linux:**
- Install and configure a mail server (Postfix, Sendmail, etc.)
- Or use a service like Mailgun, SendGrid, or SMTP

**Windows:**
- Configure `php.ini` with SMTP settings:
  ```ini
  [mail function]
  SMTP = smtp.example.com
  smtp_port = 25
  sendmail_from = your-email@example.com
  ```

### Production Deployment

For production, consider:

1. **SMTP Library** (recommended):
   - Install PHPMailer or SwiftMailer
   - Update `send_contact_email()` in `includes/functions.php`
   - Configure SMTP credentials

2. **Email Service** (easiest):
   - Use SendGrid, Mailgun, or Amazon SES
   - Update email sending function accordingly

3. **Fallback Logging**:
   - If `mail()` fails, submissions are logged to `/storage/contact_submissions.log`
   - Check this file regularly if emails aren't working
   - Format: JSON lines with timestamp and form data

### Testing Email

1. Submit the contact form
2. Check your email inbox (and spam folder)
3. If no email arrives, check `/storage/contact_submissions.log`
4. Verify `contact_recipient_email` in `/content/company.php`

## Security Features

- **XSS Prevention**: All output is escaped using `e()` helper
- **CSRF Protection**: Token-based form protection
- **Honeypot**: Hidden field to catch bots
- **Rate Limiting**: Max 3 submissions per 10 minutes per session
- **Input Validation**: Server-side validation with sanitization
- **SQL Injection**: Not applicable (no database), but all inputs are sanitized

## Customization

### Styling

Edit `/public/assets/css/styles.css` to customize:
- Colors (CSS variables in `:root`)
- Typography
- Spacing
- Layout breakpoints

### JavaScript

Edit `/public/assets/js/main.js` to customize:
- Portfolio filtering behavior
- Mobile navigation
- Form validation enhancements

### Adding Pages

1. Create new PHP file in `/public/`
2. Include header and footer:
   ```php
   <?php
   require_once __DIR__ . '/../includes/functions.php';
   $company = get_company();
   include __DIR__ . '/../includes/header.php';
   ?>
   <!-- Your content -->
   <?php include __DIR__ . '/../includes/footer.php'; ?>
   ```
3. Add navigation link in `/includes/header.php`

## Deployment

### Requirements

- PHP 8.0 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- Write permissions on `/storage` directory

### Apache Configuration

If using Apache, ensure `.htaccess` is enabled and add to `/public/.htaccess`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# Optional: Add clean URLs here if desired
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

### File Permissions

```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make storage writable
chmod 755 storage
chmod 666 storage/contact_submissions.log
```

## Troubleshooting

### Contact Form Not Sending Emails

1. Check `contact_recipient_email` in `/content/company.php`
2. Verify PHP `mail()` is configured
3. Check `/storage/contact_submissions.log` for logged submissions
4. Check server error logs
5. Test with a simple PHP mail script

### Images Not Displaying

1. Verify image files exist in `/public/assets/img/`
2. Check file names match `projects.php` exactly
3. Check file permissions (should be readable)
4. SVG fallbacks will display if images are missing

### Rate Limiting Issues

- Rate limit is session-based (resets when session expires)
- Default: 3 submissions per 10 minutes
- Adjust in `rate_limit_check()` function in `includes/functions.php`

### Navigation Not Working

- Ensure all PHP files are in `/public/` directory
- Check that `header.php` paths are correct
- Verify web server is configured to serve PHP files

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)
- Graceful degradation for older browsers
- Works without JavaScript (portfolio filter degrades gracefully)

## License

This project is provided as-is for use in your custom furniture business.

## Support

For issues or questions:
1. Check this README
2. Review PHP error logs
3. Check `/storage/contact_submissions.log` for form issues
4. Verify all configuration files are set correctly

---

**Built with care for Hinterholz Studio** 🪵
