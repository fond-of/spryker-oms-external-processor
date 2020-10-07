<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business;

use FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface;
use FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorRunner;
use FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorRunnerInterface;
use FondOfSpryker\Zed\OmsExternalProcessor\OmsExternalProcessorDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\OmsExternalProcessorConfig getConfig()
 */
class OmsExternalProcessorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorRunnerInterface
     */
    public function createProcessorRunner(): ProcessorRunnerInterface
    {
        return new ProcessorRunner($this->getExternalProcessorPlugins());
    }

    /**
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    public function getExternalProcessorPlugins(): ProcessorCollectionInterface
    {
        return $this->getProvidedDependency(OmsExternalProcessorDependencyProvider::PLUGINS_PROCESSOR);
    }
}
