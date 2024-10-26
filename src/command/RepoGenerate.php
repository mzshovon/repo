<?php

namespace Zaman\Repo\Command;

use Illuminate\Console\Command;

class RepoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:generate';

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
        $this->info("Hi there it works");
    }
}
