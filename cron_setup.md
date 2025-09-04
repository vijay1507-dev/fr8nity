# Cron Job Setup for Membership Renewal Activation

## Server Cron Configuration

Add this line to your server's crontab to run Laravel's scheduler every minute:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

For XAMPP/Windows development, you can use Windows Task Scheduler or run manually.

## Manual Execution (for testing)

```bash
# Run the renewal activation command directly
php artisan membership:activate-renewals

# Run Laravel scheduler (includes all scheduled tasks)
php artisan schedule:run
```

## Current Schedule Configuration

The renewal activation command runs **hourly** as configured in `bootstrap/app.php`:

```php
$schedule->command('membership:activate-renewals')->hourly();
```

## What the Cron Does

1. **Checks** for pending renewals where `starts_at <= utcNow()`
2. **Updates** user table with new membership dates
3. **Marks** renewal as `ACTIVE`
4. **Logs** the activation for audit trail

## Frequency Options

You can change the frequency in `bootstrap/app.php`:

```php
// Every minute (for testing)
$schedule->command('membership:activate-renewals')->everyMinute();

// Every 15 minutes
$schedule->command('membership:activate-renewals')->everyFifteenMinutes();

// Every hour (current setting)
$schedule->command('membership:activate-renewals')->hourly();

// Daily at specific time
$schedule->command('membership:activate-renewals')->dailyAt('09:00');
```

## Production Setup

For production servers, add to crontab:

```bash
# Edit crontab
crontab -e

# Add this line (replace /path/to/project with actual path)
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```
