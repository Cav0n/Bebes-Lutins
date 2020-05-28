<?php

namespace App\Console\Commands\BebesLutins;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'bebeslutins:install
            {--show : Show all success and errors messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Bébés Lutins website.';

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
        $this->info('
            ██████╗ ███████╗██████╗ ███████╗███████╗
            ██╔══██╗██╔════╝██╔══██╗██╔════╝██╔════╝
            ██████╔╝█████╗  ██████╔╝█████╗  ███████╗
            ██╔══██╗██╔══╝  ██╔══██╗██╔══╝  ╚════██║
            ██████╔╝███████╗██████╔╝███████╗███████║
            ╚═════╝ ╚══════╝╚═════╝ ╚══════╝╚══════╝

            ██╗     ██╗   ██╗████████╗██╗███╗   ██╗███████╗
            ██║     ██║   ██║╚══██╔══╝██║████╗  ██║██╔════╝
            ██║     ██║   ██║   ██║   ██║██╔██╗ ██║███████╗
            ██║     ██║   ██║   ██║   ██║██║╚██╗██║╚════██║
            ███████╗╚██████╔╝   ██║   ██║██║ ╚████║███████║
            ╚══════╝ ╚═════╝    ╚═╝   ╚═╝╚═╝  ╚═══╝╚══════╝
        ');

        if (! $this->confirm("Voulez-vous vraiment installer le site ?")) {
            return;
        }
        shell_exec('composer install');

        $this->info('Installing Bebes Lutins website, this might take a while.');

        $this->call('migrate:fresh');
        $this->call('key:generate');
        $this->call('bebeslutins:import:old');
        $this->call('bebeslutins:settings:generate');
        $this->call('bebeslutins:contents:generate');
        $this->call('bebeslutins:carts:reset');
        $this->call('db:seed', ['--class' => 'CarouselItemSeeder']);
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        shell_exec('composer install --optimize-autoloader --no-dev');

        $this->info('Bebes Lutins website installed ! 👶');
    }
}
