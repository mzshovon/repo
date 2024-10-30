<?php

namespace Zaman\Repo\Command;

use Illuminate\Console\Command;
use Zaman\Repo\Builder\TemplateBuilder;

class RepoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repo {name} {--m}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shortcut repo pattern generator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $templateBuild = new TemplateBuilder;
        $name = $this->argument('name');
        $isModel = $this->option('m');

        $templateBuild->setContract($name);
        if($isModel) {
            $templateBuild->setModel($isModel);
        }
        $templateBuild = $templateBuild->generate();
        if($templateBuild) {
            $this->info("Repository created successfully!");
        } else {
            $this->error("No repository generated yet!");
        }
    }
}
