# OMS External Processor
[![Build Status](https://travis-ci.org/fond-of/spryker-oms-external-processor.svg?branch=master)](https://travis-ci.org/fond-of/spryker-oms-external-processor)
[![PHP from Travis config](https://img.shields.io/travis/php-v/fond-of/spryker-oms-external-processor.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/fond-of/spryker-oms-external-processor.svg)](https://packagist.org/packages/fond-of-spryker/oms-external-processor)

Wrapper Module for executing external processor plugins. Handles plugins from type ExternalProcessorPluginInterface. You need at least one processor to process for example https://packagist.org/packages/fond-of-spryker/oms-external-processor-payone

## Installation

```
composer require fond-of-spryker/oms-external-processor
```

## Configuration

Extend in PYZ the OmsExternalProcessorDependencyProvider

```
/**
 * @return \FondOfSpryker\Zed\OmsExternalProcessor\Dependency\Plugin\ExternalProcessorPluginInterface[]
 */
protected function getExternalProcessorPlugins(): array
{
    return [];
}
```

## Usage

Run 'vendor/bin/console oms:external:process -r processorName' or create job
