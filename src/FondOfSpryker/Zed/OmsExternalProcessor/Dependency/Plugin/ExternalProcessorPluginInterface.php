<?php

namespace  FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin;

use Generated\Shared\Transfer\ExternalProcessingResponseTransfer;

interface ExternalProcessorPluginInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \Generated\Shared\Transfer\ExternalProcessingResponseTransfer $externalProcessingResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponseTransfer
     */
    public function process(ExternalProcessingResponseTransfer $externalProcessingResponseTransfer): ExternalProcessingResponseTransfer;
}
