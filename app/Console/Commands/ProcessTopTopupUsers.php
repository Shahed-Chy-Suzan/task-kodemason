<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessTopTopupUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'topup:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process top topup users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

        $controller = app()->make(\App\Http\Controllers\TopupController::class);
        $controller->processTopTopupUsers();
        // app(TopupController::class)->processTopTopupUsers();
        //app(TopupController::class)->processTopTopupUsers()->onQueue('default');

        $this->info('Top topup users have been updated!');

        //$this->call('get', '/process-top-topup-users');
        // return 0;
    }
}
