<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;

use Exception;
use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponseTransfer;

class ProcessorRunner implements ProcessorRunnerInterface
{
    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    protected $processorCollection;

    /**
     * @param \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface $processorCollection
     */
    public function __construct(ProcessorCollectionInterface $processorCollection)
    {
        $this->processorCollection = $processorCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\ExternalProcessingRequestsTransfer $requestsTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponsesTransfer
     */
    public function run(ExternalProcessingRequestsTransfer $requestsTransfer): ExternalProcessingResponsesTransfer
    {
        $status = new ExternalProcessingResponsesTransfer();
        foreach ($requestsTransfer->getRequests() as $request) {
            $response = new ExternalProcessingResponseTransfer();
            $response->setProcessorName($response->getProcessorName());
            try {
                $processor = $this->processorCollection->get($request->getProcessorName());
                $response = $processor->process($response);
            } catch (Exception $exception) {
                $response->setStatus('error');
                $response->setError($exception->getMessage());
                $response->setErrorTraceAsString($exception->getTraceAsString());
            }
            $status->addResponse($response);
        }

        return $status;
    }
}
