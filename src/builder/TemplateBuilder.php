<?php

namespace Zaman\Repo\Builder;

use Zaman\Repo\Classes\FileProcessor;

final readonly class TemplateBuilder
{
    /**
     * @var string
     */
    public string $interfaceName;

    /**
     * @var string|null
     */
    public ?string $modelName;

    /**
     * @var string|null
     */
    public string $interfacePathName;

    /**
     * @var string|null
     */
    public string $modelPathName;

    public readonly FileProcessor $fileProcessor;

    /**
     * @param string $interfaceName
     *
     * @return TemplateBuilder
     */
    function setInterfaceName(string $interfaceName) : TemplateBuilder
    {
        $this->interfaceName = $interfaceName;
        return $this;
    }

    /**
     * @param string $interfaceName
     *
     * @return TemplateBuilder
     */
    function getInterfaceName() : TemplateBuilder
    {
        return $this;
    }

    /**
     * @param string|null $modelName
     *
     * @return TemplateBuilder
     */
    function setModelName(?string $modelName) : TemplateBuilder
    {
        $this->modelName = $modelName;
        $this->setModelPathName();
        return $this;
    }

    /**
     * @param string $interfacePathName
     *
     * @return TemplateBuilder
     */
    function setInterfacePathName(?string $interfacePathName) : TemplateBuilder
    {
        if($interfacePathName) {

        }
        $this->interfacePathName = $interfacePathName;
        return $this;
    }

    /**
     * @param string $interfacePathName
     *
     * @return TemplateBuilder
     */
    function setModelPathName() : TemplateBuilder
    {
        $this->modelPathName = config('repo-template.model.path');
        return $this;
    }

    function setNameSpace() : TemplateBuilder
    {
        return $this;
    }

    /**
     * @return void
     */
    function generate() : void
    {
        dd("Hi its landing perfectly");
    }

}
