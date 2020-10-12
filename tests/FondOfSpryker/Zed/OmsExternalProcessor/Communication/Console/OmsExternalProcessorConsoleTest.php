<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Communication\Console;


use Codeception\Test\Unit;
use FondOfSpryker\Zed\OmsExternalProcessor\Business\OmsExternalProcessorFacadeInterface;
use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Auto-generated group annotations
 * @group FondOfSpryker
 * @group Zed
 * @group OmsExternalProcessor
 * @group Communication
 * @group Console
 * @group OmsExternalProcessorConsoleTest
 * Add your own group annotations below this line
 */
class OmsExternalProcessorConsoleTest extends Unit
{
    /**
     * @return void
     */
    public function testExecute(): void
    {
        $this->markTestSkipped();
        $self = $this;
        $responseMock = $this->getMockBuilder(ExternalProcessingResponsesTransfer::class)->disableOriginalConstructor()->getMock();
        $inputMock = $this->getMockBuilder(InputInterface::class)->disableOriginalConstructor()->getMock();
        $inputMock->method('getOption')->willReturn('test,test123');
        $outputMock = $this->getMockBuilder(OutputInterface::class)->disableOriginalConstructor()->getMock();
        $facadeMock = $this->getMockBuilder(OmsExternalProcessorFacadeInterface::class)->disableOriginalConstructor()->getMock();
        $facadeMock->method('process')->will($this->returnCallback(static function($args)use($self){
            $self->assertInstanceOf(ExternalProcessingRequestsTransfer::class, $args);
            /** @var ExternalProcessingRequestsTransfer $args */
            $requests = $args->getRequests();
            /** @var \Generated\Shared\Transfer\ExternalProcessingRequestTransfer $request1 */
            $request1 = $requests->offsetGet(0);
            /** @var \Generated\Shared\Transfer\ExternalProcessingRequestTransfer $request2 */
            $request2 = $requests->offsetGet(1);
            $self->assertSame('test', $request1->getProcessorName());
            $self->assertSame('test123', $request2->getProcessorName());
        }));

        $reflectionClass = new \ReflectionClass(OmsExternalProcessorConsole::class);
        $executeMethod = $reflectionClass->getMethod('execute');
        $executeMethod->setAccessible(true);
        $console = new OmsExternalProcessorConsole();
        $console->setFacade($facadeMock);
        $result = $executeMethod->invokeArgs($console, [$inputMock, $outputMock]);
    }
}
