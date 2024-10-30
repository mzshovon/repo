<?php

namespace Zaman\Repo\Builder;

use Zaman\Repo\Classes\AttributeGenerator;
use Zaman\Repo\Classes\FileGenerator;

final class TemplateBuilder
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
     * @var string
     */
    public string $contractPathName;

    /**
     * @var string
     */
    public string $contractNameSpace;

    /**
     * @var bool
     */
    public bool $hasModel = false;

    /**
     * @var string|null
     */
    public ?string $modelPathName;

    /**
     * @var string|null
     */
    public ?string $modelNameSpace;

    public readonly AttributeGenerator $attributeGenerator;

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
     * @param bool $hasModel
     *
     * @return TemplateBuilder
     */
    function setModel(bool $hasModel) : TemplateBuilder
    {
        $this->hasModel = $hasModel;
        $this->setModelRepository($this->contractName);
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
     *
     * @return string
     */
    function getModelName() : string
    {
        return $this->modelName;
    }

    /**
     *
     * @return string
     */
    function getModelPath() : string
    {
        return $this->modelPathName;
    }

    /**
     *
     * @return string
     */
    function getModelNameSpace() : string
    {
        return $this->modelNameSpace;
    }

    /**
     * @param string $contractName
     *
     * @return TemplateBuilder
     */
    function setContractRepository(string $contractName) : TemplateBuilder
    {
        [$contract, $path, $namespace] = (new AttributeGenerator)
                ->getContractAttribute($contractName);
        $this->contractName = $contract;
        $this->contractPathName = $path;
        $this->contractNameSpace = $namespace;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return TemplateBuilder
     */
    function setModelRepository(string $name) : TemplateBuilder
    {
        [$modelRepositoryName, $path, $namespace] = (new AttributeGenerator)
                ->getModelRepositoryAttribute($name);
        $this->modelName = $modelRepositoryName;
        $this->modelPathName = $path;
        $this->modelNameSpace = $namespace;
        return $this;
    }

    /**
     * @return void
     */
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
    function generateModel() : void
    {
        $fileGeneratorClass = new FileGenerator;
        $name = $this->getModelName();
        $path = $this->getModelPath();
        $namespace = $this->getModelNameSpace();
        $contractNameSpace = $this->getContractNameSpace();
        $fileGeneratorClass->generateModelRepository(
            $name,
            $path,
            $namespace,
            $contractNameSpace,
        );
    }

    /**
     * @return bool
     */
    function generate() : bool
    {
        $this->generateContract();
        if($this->hasModel) {
            $this->generateModel();
        }
        return true;
    }

}
