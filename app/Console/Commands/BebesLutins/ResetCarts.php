<?php

namespace App\Console\Commands\BebesLutins;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'bebeslutins:carts:reset
            {--show : Show all success and errors messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all carts.';

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
     * @return mixed
     */
    public function handle()
    {
        exec('rm -rf ' . storage_path('framework/sessions/*'));
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cart_items')->truncate();
        DB::table('carts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
