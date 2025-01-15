<?php

namespace Mzshovon\AutoRepo\Classes;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class FileGenerator
{
    const DEFAULT_CONTRACT_STUB = "/../Command/stubs/interface.stub";
    const DEFAULT_MODEL_STUB = "/../Command/stubs/model.stub";
    const DEFAULT_SERVICE_STUB = "/../Command/stubs/service.stub";
    const BIND_CONFIG_PATH = "/../config/bind-repository.php";

    /**
     * @var string
     */
    private string $contractNaming = "Interface";
    /**
     * @var string
     */
    private string $repositoryNaming = "Repository";
    /**
     * @var string
     */
    private string $serviceNaming = "Service";

    /**
     * @param string $name
     * @param string $path
     * @param string $namespace
     * @param string $definition
     *
     * @return void
     */
    function generateContract(
        string $name,
        string $path,
        string $namespace,
        string $definition,
    ) : void
    {
        $interfacePath = "{$path}/{$name}{$definition}{$this->contractNaming}.php";
        // Generate Interface
        $this->generateFile(self::DEFAULT_CONTRACT_STUB, $interfacePath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name,
            '{{ definition }}' => $definition
        ]);
    }

    /**
     * @param string $name
     * @param string $path
     * @param string $namespace
     * @param string $interfaceNamespace
     *
     * @return void
     */
    function generateModelRepository(
        string $name,
        string $path,
        string $namespace,
        string $interfaceNamespace,
    )
    {
        $modelPath = "{$path}/{$name}{$this->repositoryNaming}.php";
        // Check and create model if not exists
        $this->checkAndCreateModel($name);
        // Generate Interface
        $this->generateFile(self::DEFAULT_MODEL_STUB, $modelPath, [
            '{{ model }}' => $name,
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name,
            '{{ interfaceNamespace }}' => $interfaceNamespace,
        ]);

        // Register binding in AppServiceProvider
        $this->registerBinding(
            $name,
            $interfaceNamespace,
            $namespace,
            $this->repositoryNaming
        );
    }

    /**
     * @param string $name
     * @param string $path
     * @param string $namespace
     * @param string $interfaceNamespace
     *
     * @return void
     */
    function generateServiceRepository(
        string $name,
        string $path,
        string $namespace,
        string $interfaceNamespace,
    )
    {
        $servicePath = "{$path}/{$name}{$this->serviceNaming}.php";
        // Generate Interface
        $this->generateFile(self::DEFAULT_SERVICE_STUB, $servicePath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name,
            '{{ interfaceNamespace }}' => $interfaceNamespace,
        ]);

        // Register binding in AppServiceProvider
        $this->registerBinding(
            $name,
            $interfaceNamespace,
            $namespace,
            $this->serviceNaming
        );
    }

    /**
     * @param string $stubPath
     * @param string $filePath
     * @param array $replacements
     *
     * @return void
     */
    protected function generateFile(
        string $stubPath,
        string $filePath,
        array $replacements
    ) : void
    {
        $content = File::get(__DIR__ . $stubPath);
        // Replace placeholders with actual values
        foreach ($replacements as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        File::ensureDirectoryExists(dirname($filePath));

        if(File::exists($filePath)) {
            throw new Exception("File already exists!");
        }

        File::put($filePath, $content);
    }

    /**
     * @param string $name
     * @param string $contractNameSpace
     * @param string $namespace
     * @param string $deifnition
     *
     * @return void
     */
    protected function registerBinding(
        string $name,
        string $contractNameSpace,
        string $namespace,
        string $deifnition,
    ) : void
    {
        $config = __DIR__. self::BIND_CONFIG_PATH;
        $interface = "{$contractNameSpace}\\{$name}{$deifnition}{$this->contractNaming}";
        $implementation = "{$namespace}\\{$name}{$deifnition}";

        $bindObject = new RepositoryBindingManager($config);
        $bindObject->addBinding(
            $interface,
            $implementation
        );
    }

    /**
     * @param string $modelName
     *
     * @return void
     */
    private function checkAndCreateModel(string $modelName) : void
    {
        if(!File::exists(app_path("Models/{$modelName}.php"))) {
            Artisan::call("make:model $modelName");
        }
    }
}
