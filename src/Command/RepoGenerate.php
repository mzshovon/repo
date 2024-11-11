<?php

namespace Mzshovon\AutoRepo\Command;

use Exception;
use Illuminate\Console\Command;
use Mzshovon\AutoRepo\Builder\TemplateBuilder;

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
        $isModel = false;
        $isService = false;
        $name = $this->argument('name');
        $askForModel = $this->ask('Do you want to bind model?', "yes");

        if(strtolower($askForModel) == "yes") {
            $isModel =  true;
        } else {
            $askForService = $this->ask('Do you want to bind service?', "yes");
            if(strtolower($askForService) == "yes") {
                $isService =  true;
            }
        }

        try {
            $validateName = $this->validateString($name);
            if($validateName) {
                $templateBuild->setContract($name);
            }
            if($isModel) {
                $templateBuild->setModel($isModel);
            }
            if($isService) {
                $templateBuild->setService($isService);
            }
            $templateBuild = $templateBuild->generate();
            if($templateBuild) {
                $this->info("Repository created successfully!");
            } else {
                $this->error("No repository generated yet!");
                return 1;
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
            return 1;
        }
    }

    /**
     * @param mixed $string
     *
     */
    function validateString($string)
    {
        // Regular expression to match numbers or special characters
        if (preg_match('/[^a-zA-Z\/]/', $string)) {
            throw new Exception("The string contains numbers or special characters!");
        }

        // String is valid (only letters and spaces)
        return true;
    }
}
