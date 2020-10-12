<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;


use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface;
use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingRequestTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponseTransfer;


/**
 * Auto-generated group annotations
 * @group FondOfSpryker
 * @group Zed
 * @group OmsExternalProcessor
 * @group Business
 * @group Processor
 * @group ProcessorCollectionTest
 * Add your own group annotations below this line
 */
class ProcessorCollectionTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    protected $processorCollection;

    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $processorMock;

    public function _before()
    {
        parent::_before();

        $this->processorMock = $this->getMockBuilder(ExternalProcessorPluginInterface::class)->disableOriginalConstructor()->getMock();
        $this->processorCollection = new ProcessorCollection();
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $this->processorMock->expects($this->once())->method('getName')->willReturn('test');
        $this->assertInstanceOf(ProcessorCollectionInterface::class, $this->processorCollection->add($this->processorMock));
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->processorMock->expects($this->once())->method('getName')->willReturn('test');
        $this->processorCollection->add($this->processorMock);
        $processor = $this->processorCollection->get('test');
        $this->assertInstanceOf(ExternalProcessorPluginInterface::class, $processor);
        $this->assertSame($processor, $this->processorMock);
    }

    /**
     * @return void
     */
    public function testGetRegisteredProcessorNames(): void
    {
        $this->processorMock->expects($this->exactly(2))->method('getName')->willReturn('test');
        $this->processorCollection->add($this->processorMock);

        $this->assertSame(['test'], $this->processorCollection->getRegisteredProcessorNames());
    }
}
