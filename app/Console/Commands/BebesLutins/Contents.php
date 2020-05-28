<?php

namespace App\Console\Commands\BebesLutins;

use Illuminate\Console\Command;
use Exception;

class Contents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'bebeslutins:contents:generate
            {--show : Show all success and errors messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all contents from config/json/contents.json';

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
        $path = \base_path() . "/config/json/contents.json";

        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $fe) {
            $footerElement = new \App\FooterElement();
            $footerElement->title = $fe['title'];
            $footerElement->position = $fe['position'];

            try {
                $footerElement->save();
            } catch(Exception $e) {
                $this->error('Error happened on '.$fe['title'].' footer element importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            if ($this->option('show')) {
                $this->info($fe['title'] . ' footer element generated.');
            }

            foreach ($fe['contents'] as $co) {
                $content = new \App\Content();
                $content->title = $co['title'];
                $content->url = $co['url'];
                $content->type = $co['type'];

                try {
                    $content->save();

                    $content->footerElements()->attach($footerElement);
                } catch(Exception $e) {
                    $this->error('Error happened on '.$co['title'].' content importation.');
                    $this->error('ERROR : ' . $e->getMessage());
                }

                if ($this->option('show')) {
                    $this->info($co['title'] . ' content generated.');
                }

                foreach ($co['sections'] as $se) {
                    $section = new \App\ContentSection();
                    $section->title = $se['title'];
                    $section->text = $se['text'];
                    $section->content_id = $content->id;

                    try {
                        $section->save();
                    } catch(Exception $e) {
                        $this->error('Error happened on '.$se['title'].' content importation.');
                        $this->error('ERROR : ' . $e->getMessage());
                    }

                    if ($this->option('show')) {
                        $this->info($se['title'] . ' section generated.');
                    }
                }
            }
        }

        $this->info("All contents has been created !");
    }
}
