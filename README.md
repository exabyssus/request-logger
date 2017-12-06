# request-logger
Arbory cms request logger

##### Sanitizing sensitive data from logs
You can add your own sensitive words, keys, patterns to blacklist.

##### Cron task for clearing old log entries
If you need to clear log rows that are older than x days, then add this snippet in your apps Kernel and change values to suite your needs. Don't forget to add laravels task runner in cron!
```php
// Inside App\Console\Kernel.php

protected function schedule(Schedule $schedule)
{        
    //Every day check and delete rows that are older than 30 days
    $schedule->call(function () {
        $oldestAllowedDate = (new \DateTime)->modify('-30 days');
        \DB::table((new AdminLog())->getTable())->where('created_at', '<', $oldestAllowedDate->format('Y-m-d H:i:s'))->delete();
    })->daily();
}
```