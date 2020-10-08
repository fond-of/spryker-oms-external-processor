<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor;

use Exception;
use FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollection;
use FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface;
use FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\OmsExternalProcessorConfig getConfig()
 */
class OmsExternalProcessorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const PLUGINS_PROCESSOR = 'OMS:EXTERNAL:PROCESSOR:PROCESSOR_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addExternalProcessorPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addExternalProcessorPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PROCESSOR] = static function () use ($self) {
            return $self->createProcessorCollection();
        };

        return $container;
    }

    /**
     * @throws \Exception
     *
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    protected function createProcessorCollection(): ProcessorCollectionInterface
    {
        $collection = new ProcessorCollection();

        foreach ($this->getExternalProcessorPlugins() as $plugin) {
            if ($plugin instanceof ExternalProcessorPluginInterface) {
                $collection->add($plugin);

                continue;
            }

            throw new Exception(sprintf('Can not add processor Plugin %s', get_class($plugin)));
        }

        return $collection;
    }

    /**
     * @return \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface[]
     */
    protected function getExternalProcessorPlugins(): array
    {
        return [];
    }
}
