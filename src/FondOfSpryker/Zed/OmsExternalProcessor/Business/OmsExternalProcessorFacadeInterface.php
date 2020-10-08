<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business;

use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;

interface OmsExternalProcessorFacadeInterface
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return array
     */
    public function getRegisteredProcessor(): array;

    /**
     * @param \Generated\Shared\Transfer\ExternalProcessingRequestsTransfer $requestsTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponsesTransfer
     */
    public function process(
        ExternalProcessingRequestsTransfer $requestsTransfer
    ): ExternalProcessingResponsesTransfer;
}
