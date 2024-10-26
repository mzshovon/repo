<?php

namespace Zaman\Repo\Builder;

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
     * @param string|null $modelName
     *
     * @return TemplateBuilder
     */
    function setModelName(?string $modelName) : TemplateBuilder
    {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * @param string $interfacePathName
     *
     * @return TemplateBuilder
     */
    function setInterfacePathName(string $interfacePathName) : TemplateBuilder
    {
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
