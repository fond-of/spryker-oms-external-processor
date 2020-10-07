<?php

namespace FondOfSpryker\Zed\OmsExternalProcessor\Communication\Console;

use Exception;
use Generated\Shared\Transfer\ExternalProcessingRequestsTransfer;
use Generated\Shared\Transfer\ExternalProcessingRequestTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\OmsExternalProcessor\Business\OmsExternalProcessorFacadeInterface getFacade()
 */
class OmsExternalProcessorConsole extends Console
{
    public const COMMAND_NAME = 'oms:external:process';
    public const DESCRIPTION = 'Process external oms events';
    public const RESOURCE_OMS_EXTERNAL_PROCESSOR = 'resource';
    public const RESOURCE_OMS_EXTERNAL_PROCESSOR_SHORTCUT = 'r';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addOption(
            static::RESOURCE_OMS_EXTERNAL_PROCESSOR,
            static::RESOURCE_OMS_EXTERNAL_PROCESSOR_SHORTCUT,
            InputArgument::OPTIONAL,
            sprintf(
                'Defines the processor resources to use. Available processor: %s-> %s',
                PHP_EOL,
                implode(PHP_EOL . '-> ', $this->getFacade()->getRegisteredProcessor())
            )
        );

        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION)
            ->addUsage(sprintf('-%s resource', static::RESOURCE_OMS_EXTERNAL_PROCESSOR_SHORTCUT));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $status = static::CODE_SUCCESS;
        $messenger = $this->getMessenger();

        $processingRequest = new ExternalProcessingRequestsTransfer();
        if ($input->getOption(static::RESOURCE_OMS_EXTERNAL_PROCESSOR)) {
            $resourceString = $input->getOption(static::RESOURCE_OMS_EXTERNAL_PROCESSOR);
            $resources = explode(',', $resourceString);
            foreach ($resources as $resource) {
                $request = new ExternalProcessingRequestTransfer();
                $request->setProcessorName($resource);
                $processingRequest->addRequest($request);
            }
        }

        try {
            $responsesTransfer = $this->getFacade()->process($processingRequest);
            //ToDo Maybe handle responses
        } catch (Exception $exception) {
            $status = static::CODE_ERROR;
            $messenger->error(sprintf(
                'Command %s failt with message: %s%s!',
                static::COMMAND_NAME,
                PHP_EOL,
                $exception->getMessage()
            ));
        }

        $messenger->info(sprintf(
            'You just executed %s!',
            static::COMMAND_NAME
        ));

        return $status;
    }
}
