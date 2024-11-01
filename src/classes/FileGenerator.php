<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\File;

class FileGenerator
{
    const DEFAULT_CONTRACT_STUB = "/../command/stubs/interface.stub";
    const DEFAULT_MODEL_STUB = "/../command/stubs/model.stub";
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
     * @param string $name
     * @param string $path
     * @param string $namespace
     *
     * @return void
     */
    function generateContract(
        string $name,
        string $path,
        string $namespace
    ) : void
    {
        $interfacePath = "{$path}/{$name}{$this->repositoryNaming}{$this->contractNaming}.php";
        // Generate Interface
        $this->generateFile(self::DEFAULT_CONTRACT_STUB, $interfacePath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name
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
        // Generate Interface
        $this->generateFile(self::DEFAULT_MODEL_STUB, $modelPath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name,
            '{{ interfaceNamespace }}' => $interfaceNamespace,
        ]);

        // Register binding in AppServiceProvider
        $this->registerBinding(
            $name,
            $interfaceNamespace,
            $namespace
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
        File::put($filePath, $content);
    }

    /**
     * @param string $name
     * @param string $contractNameSpace
     * @param string $modelNameSpace
     *
     * @return void
     */
    protected function registerBinding(
        string $name,
        string $contractNameSpace,
        string $modelNameSpace,
    ) : void
    {
        $config = __DIR__. self::BIND_CONFIG_PATH;
        $interface = "{$contractNameSpace}\\{$name}{$this->repositoryNaming}{$this->contractNaming}";
        $implementation = "{$modelNameSpace}\\{$name}{$this->repositoryNaming}";

        $bindObject = new RepositoryBindingManager($config);
        $bindObject->addBinding(
            $interface,
            $implementation
        );
    }
}
