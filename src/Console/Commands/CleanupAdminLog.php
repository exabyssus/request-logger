<?php

namespace Arbory\AdminLog\Console\Commands;

use Arbory\AdminLog\Models\AdminLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupAdminLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arbory:cleanup-admin-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup Arbory admin log table';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $retainFor = config('admin-log.cleanup.retain_for_days', 0);

        if ($retainFor) {
            $expiredBefore = Carbon::now()->subDays($retainFor);

            AdminLog::query()
                ->whereDate('created_at', '<=', $expiredBefore)
                ->delete();
        }
    }
}
