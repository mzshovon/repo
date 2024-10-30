<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\File;

class FileGenerator
{
    const DEFAULT_CONTRACT_STUB = "/../command/stubs/interface.stub";
    const DEFAULT_MODEL_STUB = "/../command/stubs/model.stub";

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
        $interfacePath = "{$path}/{$name}RepositoryInterface.php";
        // Generate Interface
        $this->generateFile(self::DEFAULT_CONTRACT_STUB, $interfacePath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name
        ]);

        // Register binding in AppServiceProvider
        $this->registerBinding(
            $namespace,
            "{$name}RepositoryInterface",
            "{$name}Repository"
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
    function generateModelRepository(
        string $name,
        string $path,
        string $namespace,
        string $interfaceNamespace,
    )
    {
        $modelPath = "{$path}/{$name}Repository.php";
        // Generate Interface
        $this->generateFile(self::DEFAULT_MODEL_STUB, $modelPath, [
            '{{ namespace }}' => $namespace,
            '{{ className }}' => $name,
            '{{ interfaceNamespace }}' => $interfaceNamespace,
        ]);

        // Register binding in AppServiceProvider
        $this->registerBinding(
            $namespace,
            "{$name}Repository",
            "{$name}"
        );
    }

    protected function generateFile($stubPath, $filePath, $replacements)
    {
        $content = File::get(__DIR__ . $stubPath);
        // Replace placeholders with actual values
        foreach ($replacements as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, $content);
    }

    protected function registerBinding($namespace, $interface, $implementation)
    {
        // Code here....
    }
}
