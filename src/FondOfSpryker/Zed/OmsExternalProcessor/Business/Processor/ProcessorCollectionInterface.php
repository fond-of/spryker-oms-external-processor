<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;

use FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface;

interface ProcessorCollectionInterface
{
    /**
     * @param \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface $processor
     *
     * @return $this
     */
    public function add(ExternalProcessorPluginInterface $processor): self;

    /**
     * @param string $name
     *
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface
     */
    public function get(string $name): ExternalProcessorPluginInterface;

    /**
     * @return array
     */
    public function getRegisteredProcessorNames(): array;
}
