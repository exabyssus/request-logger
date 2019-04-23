## Installation
Require arbory/request-logger via composer
```bash
composer require arbory/request-logger
```

#### Publish config files and translations
```bash
php artisan vendor:publish --provider="Arbory\AdminLog\AdminLogServiceProvider" --tag="config"
php artisan vendor:publish --provider="Arbory\AdminLog\AdminLogServiceProvider" --tag="translations"
```

#### Run migrations
```bash
php artisan migrate
```

#### Enable module by adding to config `config/arbory.php` and register routes in `routes/admin.php`
```php  
'menu' => [
    ...
    \Arbory\AdminLog\Http\Controllers\Admin\AdminLogController::class
]
```

```php  
Admin::modules()->register(\Arbory\AdminLog\Http\Controllers\Admin\AdminLogController::class);
```

## Usage

#### Configure sanitized data
Add your own sensitive words, keys, patterns to blacklist in `sanitizer` section of `config/admin-log.php`. 

#### Schedule cleaning up of old logs
Add `arbory:cleanup-admin-log` to your app schedule to clean old log entries.
By default this will delete all records older than 365 days. 
You can specify other retain period in configuration `config/admin-log`, updating `retain_for_days` parameter.