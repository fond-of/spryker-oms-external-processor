<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business\Processor;

use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;

interface ProcessorRunnerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ExternalProcessingRequestsTransfer $requestsTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponsesTransfer
     */
    public function run(ExternalProcessingRequestsTransfer $requestsTransfer): ExternalProcessingResponsesTransfer;
}
