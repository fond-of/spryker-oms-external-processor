<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Business;

use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingResponsesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\Business\OmsExternalProcessorBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\Persistence\OmsExternalProcessorEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\Persistence\OmsExternalProcessorRepositoryInterface getRepository()
 */
class OmsExternalProcessorFacade extends AbstractFacade implements OmsExternalProcessorFacadeInterface
{
    /**
     * @return array
     */
    public function getRegisteredProcessor(): array
    {
        return $this->getFactory()->getExternalProcessorPlugins()->getRegisteredProcessorNames();
    }

    /**
     * @param \Generated\Shared\Transfer\ExternalProcessingRequestsTransfer $requestsTransfer
     *
     * @return \Generated\Shared\Transfer\ExternalProcessingResponsesTransfer
     */
    public function process(
        ExternalProcessingRequestsTransfer $requestsTransfer
    ): ExternalProcessingResponsesTransfer {
        return $this->getFactory()->createProcessorRunner()->run($requestsTransfer);
    }
}
