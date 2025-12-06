# Mail Configuration Guide for ImpactGuru CRM

## Setting Up Email Service

### Option 1: Mailtrap (Recommended for Development)

Mailtrap is a great service for testing emails in development without sending actual emails.

1. **Create Mailtrap Account**
   - Go to https://mailtrap.io
   - Sign up for a free account
   - Create a new project (e.g., "ImpactGuru CRM")

2. **Get Credentials**
   - In your Mailtrap project, go to the "Integrations" or "SMTP Settings" tab
   - You'll see something like:
     ```
     Host: smtp.mailtrap.io
     Port: 2525
     Username: (your_username)
     Password: (your_password)
     ```

3. **Update .env File**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="noreply@impactguru.local"
   MAIL_FROM_NAME="ImpactGuru CRM"
   ```

4. **Test Configuration**
   ```bash
   php artisan tinker
   
   Mail::send('mails.test', [], function($m) {
       $m->to('test@example.com')
         ->subject('Test Email');
   });
   ```
   
   Check your Mailtrap inbox for the test email.

### Option 2: Gmail (Simple Setup)

1. **Enable 2-Factor Authentication**
   - Go to https://myaccount.google.com/security
   - Enable 2-Step Verification

2. **Create App Password**
   - Go to https://myaccount.google.com/apppasswords
   - Select "Mail" and "Windows Computer"
   - Generate the password

3. **Update .env File**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@impactguru.local"
   MAIL_FROM_NAME="ImpactGuru CRM"
   ```

### Option 3: SendGrid

1. **Create SendGrid Account**
   - Go to https://sendgrid.com
   - Create an account and verify your domain

2. **Create API Key**
   - In SendGrid dashboard, go to Settings > API Keys
   - Create a new API key with "Mail Send" permissions

3. **Update .env File**
   ```env
   MAIL_MAILER=sendgrid
   SENDGRID_API_KEY=your_sendgrid_api_key
   MAIL_FROM_ADDRESS="noreply@impactguru.local"
   MAIL_FROM_NAME="ImpactGuru CRM"
   ```

### Option 4: Custom SMTP

If you have your own mail server or use a different service:

```env
MAIL_MAILER=smtp
MAIL_HOST=your.mailserver.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@impactguru.local"
MAIL_FROM_NAME="ImpactGuru CRM"
```

## Database Notifications

The CRM uses database notifications for order creation. To set up the database table:

```bash
php artisan notifications:table
php artisan migrate
```

This creates a `notifications` table to store notification history.

## Testing Notifications

### Send Test Notification
```bash
php artisan tinker

$user = User::first();
$order = Order::first();

// Send notification
$user->notify(new \App\Notifications\NewOrderNotification($order));

// View notifications
echo $user->notifications;

// Mark as read
$user->notifications->markAsRead();
```

### View Admin Notifications

1. In the application, admins will see notifications in their dashboard (when implemented)
2. Database notifications can be queried:
   ```php
   $user->unreadNotifications;
   $user->notifications;
   ```

## Creating Custom Notifications

Example: Create a new notification for customer signup

```bash
php artisan make:notification CustomerRegisteredNotification
```

Then in `app/Notifications/CustomerRegisteredNotification.php`:

```php
<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Customer Registered: {$this->customer->name}")
            ->line("A new customer has registered in the system.")
            ->line("Name: " . $this->customer->name)
            ->line("Email: " . $this->customer->email)
            ->action('View Customer', url("/customers/{$this->customer->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'message' => "New customer {$this->customer->name} registered",
        ];
    }
}
```

## Queue Configuration

For better performance, configure queues to process notifications asynchronously:

```env
QUEUE_CONNECTION=database
```

Then run the queue worker:

```bash
php artisan queue:work
```

Or use other queue drivers like Redis, Beanstalkd, etc.

## Mail Templates

Laravel uses Blade templates for emails. Example template at `resources/views/mails/test.blade.php`:

```blade
@component('mail::message')
# Hello!

This is a test email.

@component('mail::button', ['url' => 'https://example.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
```

## Troubleshooting

### Emails not sending?

1. **Check .env configuration**
   ```bash
   php artisan tinker
   echo config('mail.mailer');
   echo config('mail.host');
   ```

2. **Test SMTP connection**
   ```bash
   php artisan tinker
   
   Mail::raw('Test', function($m) {
       $m->to('test@example.com')->subject('Test');
   });
   ```

3. **Check logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Enable debug mode** (development only)
   ```env
   MAIL_DEBUG=true
   ```

### Common Issues

| Issue | Solution |
|-------|----------|
| "Authentication failed" | Check username and password in .env |
| "Connection timeout" | Check MAIL_HOST and MAIL_PORT |
| "SSL/TLS certificate error" | Set MAIL_ENCRYPTION=tls or ssl |
| "Too many failed login attempts" | Account locked; use app-specific passwords |

## Production Checklist

- [ ] Use production email service (SendGrid, AWS SES, etc.)
- [ ] Set `MAIL_FROM_ADDRESS` to a valid domain email
- [ ] Use environment-specific credentials
- [ ] Configure queue worker for async processing
- [ ] Set up email delivery monitoring
- [ ] Test notification delivery
- [ ] Configure bounce/complaint handling

## Notification Channels

The application currently uses:
1. **Mail** - Send emails to admins when orders are created
2. **Database** - Store notifications in database for later viewing

Other available channels:
- **SMS** - Via Twilio
- **Slack** - For team notifications
- **Telegram** - For quick alerts
- **Firebase** - For push notifications

See [Laravel Notifications Documentation](https://laravel.com/docs/notifications) for more info.
