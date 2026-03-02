<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business;

use Spryker\Zed\Dataset\Business\CsvFactory\CsvFactory;
use Spryker\Zed\Dataset\Business\Finder\DatasetFinder;
use Spryker\Zed\Dataset\Business\Finder\DatasetFinderInterface;
use Spryker\Zed\Dataset\Business\Reader\Reader;
use Spryker\Zed\Dataset\Business\Reader\ReaderInterface;
use Spryker\Zed\Dataset\Business\Resolver\ResolverPath;
use Spryker\Zed\Dataset\Business\Resolver\ResolverPathInterface;
use Spryker\Zed\Dataset\Business\Saver\DatasetSaver;
use Spryker\Zed\Dataset\Business\Saver\DatasetSaverInterface;
use Spryker\Zed\Dataset\Business\Writer\Writer;
use Spryker\Zed\Dataset\Business\Writer\WriterInterface;
use Spryker\Zed\Dataset\DatasetDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\Dataset\Persistence\DatasetRepositoryInterface getRepository()
 * @method \Spryker\Zed\Dataset\Persistence\DatasetEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Dataset\DatasetConfig getConfig()
 */
class DatasetBusinessFactory extends AbstractBusinessFactory
{
    public function createDatasetFinder(): DatasetFinderInterface
    {
        return new DatasetFinder(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    public function createDatasetSaver(): DatasetSaverInterface
    {
        return new DatasetSaver(
            $this->getEntityManager(),
            $this->createReader(),
        );
    }

    public function createReader(): ReaderInterface
    {
        return new Reader($this->getCsvFactory());
    }

    public function createWriter(): WriterInterface
    {
        return new Writer($this->getCsvFactory());
    }

    public function createResolverPath(): ResolverPathInterface
    {
        return new ResolverPath();
    }

    public function getCsvFactory(): CsvFactory
    {
        return $this->getProvidedDependency(DatasetDependencyProvider::CSV_ADAPTER);
    }
}
