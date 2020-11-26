<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:caches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All Laravel Related Caches';

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
        Artisan::call('route:clear');
        $this->info('All routes cache has just been removed');
        Artisan::call('config:cache');
        $this->info('Config cache has just been removed');
        Artisan::call('cache:clear');
        $this->info('Application cache has just been removed');
        Artisan::call('view:clear');
        $this->info('View cache has jut been removed');
        return 0;
    }
}
