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
 * @group ProcessRunnerTest
 * Add your own group annotations below this line
 */
class ProcessRunnerTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $processorCollection;

    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $processor;

    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorRunnerInterface
     */
    protected $processRunner;

    public function _before()
    {
        parent::_before();

        $this->processorCollection = $this->getMockBuilder(ProcessorCollectionInterface::class)->disableOriginalConstructor()->getMock();
        $this->processor = $this->getMockBuilder(ExternalProcessorPluginInterface::class)->disableOriginalConstructor()->getMock();

        $this->processRunner = new ProcessorRunner(
            $this->processorCollection
        );
    }

    /**
     * @return void
     */
    public function testRunWithoutRequests(): void
    {
        $requestsTransfer = $this->getMockBuilder(ExternalProcessingRequestsTransfer::class)->getMock();
        $requestsTransfer->expects($this->once())->method('getRequests')->willReturn([]);
        $response = $this->processRunner->run($requestsTransfer);
        $this->assertInstanceOf(ExternalProcessingResponsesTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testRun(): void
    {
        $self = $this;
        $requestMock = $this->getMockBuilder(ExternalProcessingRequestTransfer::class)->getMock();
        $requestMock->expects($this->exactly(2))->method('getProcessorName')->willReturn('test');
        $requestCollection = new ArrayObject();
        $requestCollection->offsetSet('test', $requestMock);
        $requestsTransfer = $this->getMockBuilder(ExternalProcessingRequestsTransfer::class)->getMock();
        $requestsTransfer->expects($this->once())->method('getRequests')->willReturn($requestCollection);

        $this->processor->expects($this->once())->method('process')->will($this->returnCallback(static function($args) use($self){
            $self->assertInstanceOf(ExternalProcessingResponseTransfer::class, $args);
            return $args;
        }));
        $this->processorCollection->expects($this->once())->method('get')->will($this->returnCallback(static function($args) use($self){
            $self->assertSame('test', $args);
            return $self->processor;
        }));

        $response = $this->processRunner->run($requestsTransfer);
        $this->assertInstanceOf(ExternalProcessingResponsesTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testRunCatchesException(): void
    {
        $this->markTestSkipped();
        $self = $this;
        $requestMock = $this->getMockBuilder(ExternalProcessingRequestTransfer::class)->getMock();
        $requestMock->expects($this->exactly(3))->method('getProcessorName')->willReturn('test');
        $requestCollection = new ArrayObject();
        $requestCollection->offsetSet('test', $requestMock);
        $requestsTransfer = $this->getMockBuilder(ExternalProcessingRequestsTransfer::class)->getMock();
        $requestsTransfer->expects($this->once())->method('getRequests')->willReturn($requestCollection);

        $this->processor->expects($this->once())->method('process')->will($this->returnCallback(static function($args) use($self){
            $self->assertInstanceOf(ExternalProcessingResponseTransfer::class, $args);
            throw new \Exception('fail');
        }));
        $this->processorCollection->expects($this->once())->method('get')->will($this->returnCallback(static function($args) use($self){
            $self->assertSame('test', $args);
            return $self->processor;
        }));

        $response = $this->processRunner->run($requestsTransfer);
        $this->assertInstanceOf(ExternalProcessingResponsesTransfer::class, $response);
        foreach ($response->getResponses() as $item){
            $this->assertFalse($item->getSuccess());
            $this->assertSame($item->getError(), 'Failed to handle orders for processor test. Message: test');
        }
    }
}
