<?php

namespace Zaman\Repo\Builder;

use Zaman\Repo\Classes\AttributeGenerator;
use Zaman\Repo\Classes\FileGenerator;

final readonly class TemplateBuilder
{
    /**
     * @var string
     */
    public string $contractName;

    /**
     * @var string|null
     */
    public ?string $modelName;

    /**
     * @var string|null
     */
    public string $contractPathName;

    /**
     * @var string|null
     */
    public string $contractNameSpace;

    /**
     * @var string|null
     */
    public string $modelPathName;

    public readonly AttributeGenerator $fileProcessor;

    /**
     * @param string $contract
     *
     * @return TemplateBuilder
     */
    function setContract(string $contract) : TemplateBuilder
    {
        $this->setContractRepository($contract);
        return $this;
    }

    /**
     *
     * @return string
     */
    function getContractName() : string
    {
        return $this->contractName;
    }

    /**
     *
     * @return string
     */
    function getContractPath() : string
    {
        return $this->contractPathName;
    }

    /**
     *
     * @return string
     */
    function getContractNameSpace() : string
    {
        return $this->contractNameSpace;
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
     * @param string $contractName
     *
     * @return TemplateBuilder
     */
    function setContractRepository(string $contractName) : TemplateBuilder
    {
        [$contract, $path, $namespace] = (new AttributeGenerator)
                ->getContractNameWithPathAndNamespace($contractName);
        $this->contractName = $contract;
        $this->contractPathName = $path;
        $this->contractNameSpace = $namespace;
        return $this;
    }

    /**
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

    function generateContract() : void
    {
        $fileGeneratorClass = new FileGenerator;
        $name = $this->getContractName();
        $path = $this->getContractPath();
        $namespace = $this->getContractNameSpace();
        $fileGeneratorClass->generateContract(
            $name,
            $path,
            $namespace,
        );
    }

    /**
     * @return void
     */
    function generate() : void
    {
        $this->generateContract();
        dd(
            "contract {$this->contractName}",
            "contract {$this->contractPathName}",
            "contract {$this->contractNameSpace}",
            "Hi its landing perfectly"
        );
    }

}
