<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\File;

class FileProcessor
{
    const PERM_ALL = 777;

    /**
     * @param string $name
     *
     * @return array
     */
    function getContractNameWithPath(string $name) : array
    {
        [$contractName, $path, $namespace] = [$name, null, null];
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
}
