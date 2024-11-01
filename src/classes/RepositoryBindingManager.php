<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

final class RepositoryBindingManager
{
    private string $configPath;
    private array $currentBindings;

    /**
     * @param string|null $configPath
     */
    public function __construct(string $configPath = null)
    {
        $this->configPath = $configPath ?? config_path('bind-repository.php');
        $this->currentBindings = $this->loadCurrentBindings();
    }

    private function loadCurrentBindings(): array
    {
        if (!File::exists($this->configPath)) {
            return ['bind' => []];
        }
        return require $this->configPath;
    }

    /**
     * @param string $interface
     * @param string $implementation
     *
     * @return void
     */
    public function addBinding(
        string $interface,
        string $implementation
    ): void
    {
        $this->currentBindings['bind'][$interface] = $implementation;
        $this->writeBindings();
        $this->configCache();

    }

    /**
     * @param string $interface
     *
     * @return void
     */
    public function removeBinding(string $interface): void
    {
        unset($this->currentBindings['bind'][$interface]);
        $this->writeBindings();
    }

    /**
     * @return array
     */
    public function getBindings() : array
    {
        $bindConfig = config('bind-repository.bind') ?? [];
        return $bindConfig;
    }

    /**
     * @return void
     */
    private function writeBindings(): void
    {
        $content = "<?php\n\nreturn [\n    'bind' => [\n";

        foreach ($this->currentBindings['bind'] as $interface => $implementation) {
            $content .= sprintf("        '%s' => '%s',\n", $interface, $implementation);
        }

        $content .= "    ]\n];";

        File::put($this->configPath, $content);
    }

    /**
     * @return void
     */
    private function configCache(): void
    {
        Artisan::call('config:cache');
    }
}
