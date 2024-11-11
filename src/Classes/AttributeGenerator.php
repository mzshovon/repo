<?php

namespace Mzshovon\AutoRepo\Classes;

class AttributeGenerator
{
    const PERM_ALL = 777;

    /**
     * @param string $name
     *
     * @return array
     */
    function getContractAttribute(string $name) : array
    {
        [$contractName, $path, $namespace] = [
            ucfirst($name),
            $this->getDefaultContractPath(),
            $this->getDefaultContractNamespace()
        ];
        if(str_contains($name, "/")) {
            [$contractName, $path, $namespace] = $this->parseAndSetAttribute($name);
        }
        return [$contractName, $path, $namespace];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    function getModelRepositoryAttribute(string $name) : array
    {
        [$modelRepositoryName, $path, $namespace] = [
            ucfirst($name),
            $this->getDefaultModelPath(),
            $this->getDefaultModelNamespace()
        ];
        return [$modelRepositoryName, $path, $namespace];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    function getServiceRepositoryAttribute(string $name) : array
    {
        [$serviceRepositoryName, $path, $namespace] = [
            ucfirst($name),
            $this->getDefaultServicePath(),
            $this->getDefaultServiceNamespace()
        ];
        return [$serviceRepositoryName, $path, $namespace];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function parseAndSetAttribute(string $name) : array
    {
        $splittedString = explode("/", $name);
        $firstWord = strtolower($splittedString[0]);
        $lastIndex = count($splittedString) - 1;
        $name = ucfirst($splittedString[$lastIndex]);
        unset($splittedString[$lastIndex]);
        $path = $this->buildPathNameFromArr($splittedString);
        $namespace = $this->buildNameSpaceFromArr($splittedString);
        if($firstWord != "app") {
            $path = "App/{$path}";
            $namespace = "App\\{$namespace}";
        }
        return [$name, $path, $namespace];
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
    private function getDefaultServicePath() : string
    {
        return config('repo-template.service.path');
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

    /**
     * @return string
     */
    private function getDefaultServiceNamespace() : string
    {
        return config('repo-template.service.namespace');
    }
}
