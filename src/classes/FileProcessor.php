<?php

namespace Zaman\Repo\Classes;

use Illuminate\Support\Facades\File;

class FileProcessor
{
    const PERM_ALL = 777;

    function checkAndMakeDir(string $path)
    {
        if(!File::exists($path)) {
            File::makeDirectory($path, self::PERM_ALL, true);
        }
    }
}
