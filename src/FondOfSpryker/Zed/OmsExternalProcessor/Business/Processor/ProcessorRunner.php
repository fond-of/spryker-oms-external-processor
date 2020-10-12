<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;

use Exception;
use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponseTransfer;
use Spryker\Shared\Log\LoggerTrait;

class ProcessorRunner implements ProcessorRunnerInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface
     */
    protected $processorCollection;

    /**
     * @param  \FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor\ProcessorCollectionInterface  $processorCollection
     */
    public function __construct(ProcessorCollectionInterface $processorCollection)
    {
        $this->processorCollection = $processorCollection;
    }

    /**
     * @param  \Generated\Shared\Transfer\ExternalProcessingRequestsTransfer  $requestsTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponsesTransfer
     */
    public function run(ExternalProcessingRequestsTransfer $requestsTransfer): ExternalProcessingResponsesTransfer
    {
        $status = new ExternalProcessingResponsesTransfer();
        foreach ($requestsTransfer->getRequests() as $request) {
            $response = new ExternalProcessingResponseTransfer();
            $response->setProcessorName($request->getProcessorName());
            try {
                $processor = $this->processorCollection->get($request->getProcessorName());
                $response = $processor->process($response);
                $response->setSuccess(true);
                if ($response->getFailedOrders() !== null && $response->getFailedOrders()->count() > 0) {
                    $response->setSuccess(false);
                }
            } catch (Exception $exception) {
                $response->setSuccess(false);
                $response->setError($exception->getMessage());
                $response->setErrorTrace($exception->getTraceAsString());
                $this->getLogger()->error(sprintf('Failed to handle orders for processor %s. Message: %s',
                    $request->getProcessorName(), $exception->getMessage()), $exception->getTrace());
            }
            $status->addResponse($response);
        }

        return $status;
    }
}
