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

        $templateBuild->setInterfaceName($name);
        if($isModel) {
            $templateBuild->setModelName($isModel);
        }
        $templateBuild->generate();

        $this->info("Hi there it works");
    }
}
