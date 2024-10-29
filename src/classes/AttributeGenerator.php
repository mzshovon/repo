<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\File;

class AttributeGenerator
{
    const PERM_ALL = 777;

    /**
     * @param string $name
     *
     * @return array
     */
    function getContractNameWithPathAndNamespace(string $name) : array
    {
        [$contractName, $path, $namespace] = [
            $name,
            $this->getDefaultContractPath(),
            $this->getDefaultContractNamespace()
        ];
        if(str_contains($name, "/")) {
            $splittedString = explode("/", $name);
            $lastIndex = count($splittedString) - 1;
            $contractName = $splittedString[$lastIndex];
            unset($splittedString[$lastIndex]);
            $path = $this->buildPathNameFromArr($splittedString);
            $namespace = $this->buildNameSpaceFromArr($splittedString);
        }
        return [$contractName, $path, $namespace];
    }

    /**
     * @param string $path
     *
     * @return void
     */
    function checkAndMakeDir(string $path) : void
    {
        if(!File::exists($path)) {
            File::makeDirectory($path, self::PERM_ALL, true);
        }
    }

    /**
     * @param array $arr
     *
     * @return string
     */
    private function buildPathNameFromArr(array $arr) : string
    {
        return implode('/', $arr);
    }

    /**
     * @param array $arr
     *
     * @return string
     */
    private function buildNameSpaceFromArr(array $arr) : string
    {
        return implode('\\', $arr);
    }

    /**
     * @return string
     */
    private function getDefaultContractPath() : string
    {
        return config('repo-template.interface.path');
    }

    /**
     * @return string
     */
    private function getDefaultModelPath() : string
    {
        return config('repo-template.model.path');
    }

    /**
     * @return string
     */
    private function getDefaultContractNamespace() : string
    {
        return config('repo-template.interface.namespace');
    }

    /**
     * @return string
     */
    private function getDefaultModelNamespace() : string
    {
        return config('repo-template.model.namespace');

    }
}
