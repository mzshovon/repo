<?php

namespace Mzshovon\AutoRepo\Builder;

use Mzshovon\AutoRepo\Classes\AttributeGenerator;
use Mzshovon\AutoRepo\Classes\FileGenerator;

final class TemplateBuilder
{
    /**
     * @var string
     */
    public string $contractName;

    /**
     * @var string
     */
    public string $contractDefinition = "Repository";

    /**
     * @var string|null
     */
    public ?string $modelName;

    /**
     * @var string|null
     */
    public ?string $serviceName;

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
     * @var bool
     */
    public bool $hasService = false;

    /**
     * @var string|null
     */
    public ?string $modelPathName;

    /**
     * @var string|null
     */
    public ?string $servicePathName;

    /**
     * @var string|null
     */
    public ?string $modelNameSpace;

    /**
     * @var string|null
     */
    public ?string $serviceNameSpace;

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
     * @param bool $hasModel
     *
     * @return TemplateBuilder
     */
    function setService(bool $hasService) : TemplateBuilder
    {
        $this->hasService = $hasService;
        $this->setServiceRepository($this->contractName);
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
     *
     * @return string
     */
    function getServiceName() : string
    {
        return $this->serviceName;
    }

    /**
     *
     * @return string
     */
    function getServicePath() : string
    {
        return $this->servicePathName;
    }

    /**
     *
     * @return string
     */
    function getServiceNameSpace() : string
    {
        return $this->serviceNameSpace;
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
     * @param string $name
     *
     * @return TemplateBuilder
     */
    function setServiceRepository(string $name) : TemplateBuilder
    {
        [$serviceRepositoryName, $path, $namespace] = (new AttributeGenerator)
                ->getServiceRepositoryAttribute($name);
        $this->serviceName = $serviceRepositoryName;
        $this->servicePathName = $path;
        $this->serviceNameSpace = $namespace;
        $this->contractDefinition = "Service";
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
        $definition = $this->contractDefinition;
        $fileGeneratorClass->generateContract(
            $name,
            $path,
            $namespace,
            $definition
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
     * @return void
     */
    function generateService() : void
    {
        $fileGeneratorClass = new FileGenerator;
        $name = $this->getServiceName();
        $path = $this->getServicePath();
        $namespace = $this->getServiceNameSpace();
        $contractNameSpace = $this->getContractNameSpace();
        $fileGeneratorClass->generateServiceRepository(
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
        if($this->hasService) {
            $this->generateService();
        }
        return true;
    }

}
