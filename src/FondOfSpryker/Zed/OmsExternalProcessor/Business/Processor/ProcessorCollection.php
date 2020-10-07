<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;

use ArrayObject;
use FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface;
use FondOfSpryker\Zed\OmsExternalProcessor\Exception\ExternalProcessorNotFoundException;

class ProcessorCollection implements ProcessorCollectionInterface
{
    /**
     * @var \ArrayObject | \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface[]
     */
    protected $processor;

    public function __construct()
    {
        $this->processor = new ArrayObject();
    }

    /**
     * @param \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface $processor
     *
     * @return $this|\FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    public function add(ExternalProcessorPluginInterface $processor): ProcessorCollectionInterface
    {
        $this->processor->offsetSet($processor->getName(), $processor);

        return $this;
    }

    /**
     * @param string $name
     *
     * @throws \FondOfSpryker\Zed\OmsExternalProcessor\Exception\ExternalProcessorNotFoundException
     *
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface
     */
    public function get(string $name): ExternalProcessorPluginInterface
    {
        if ($this->processor->offsetExists($name)) {
            return $this->processor->offsetGet($name);
        }

        throw new ExternalProcessorNotFoundException(sprintf('External processor with name %s not found!', $name));
    }

    /**
     * @return array
     */
    public function getRegisteredProcessorNames(): array
    {
        $names = [];
        foreach ($this->processor as $processor) {
            $names[] = $processor->getName();
        }

        return $names;
    }
}
