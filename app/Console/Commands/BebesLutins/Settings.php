<?php

namespace App\Console\Commands\BebesLutins;

use Exception;
use Illuminate\Console\Command;

class Settings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'bebeslutins:settings:generate
            {--show : Show all success and errors messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all settings from config/json/settings.json';

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
        $path = \base_path() . "/config/json/settings.json";

        $json = json_decode(file_get_contents($path), true);

        foreach ($json['settings'] as $value) {
            $setting = new \App\Setting();

            $setting->type = $value['type'];
            $setting->key = $value['key'];
            $setting->value = $value['value'];

            try {
                $setting->save();
            } catch(Exception $e) {
                $this->error('Error happened on '.$value['key'].' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            if ($this->option('show')) {
                $this->info($value['key'] . ' setting imported.');
            }

            foreach ($value['i18n'] as $valueI18n) {
                $settingI18n = new \App\SettingsI18n();

                $settingI18n->setting_id = $setting->id;
                $settingI18n->locale = $valueI18n['locale'];
                $settingI18n->title = $valueI18n['title'];
                $settingI18n->help = $valueI18n['help'];

                try {
                    $settingI18n->save();
                } catch(Exception $e) {
                    $this->error('Error happened on '.$value['key'].' importation.');
                    $this->error('ERROR : ' . $e->getMessage());
                }

                if ($this->option('show')) {
                    $this->info($value['key'] . ' setting translation imported.');
                }
            }
        }

        $this->info("All settings has been imported, congrats !");
    }
}
