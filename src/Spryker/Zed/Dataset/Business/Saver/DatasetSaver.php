<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Saver;

use Generated\Shared\Transfer\DatasetFilePathTransfer;
use Generated\Shared\Transfer\DatasetTransfer;
use Spryker\Zed\Dataset\Business\Reader\ReaderInterface;
use Spryker\Zed\Dataset\Persistence\DatasetEntityManagerInterface;

class DatasetSaver implements DatasetSaverInterface
{
    /**
     * @var \Spryker\Zed\Dataset\Persistence\DatasetEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Spryker\Zed\Dataset\Business\Reader\ReaderInterface
     */
    protected $reader;

    public function __construct(
        DatasetEntityManagerInterface $entityManager,
        ReaderInterface $reader
    ) {
        $this->entityManager = $entityManager;
        $this->reader = $reader;
    }

    public function save(DatasetTransfer $datasetTransfer, ?DatasetFilePathTransfer $filePathTransfer = null): void
    {
        if ($filePathTransfer !== null && file_exists($filePathTransfer->getFilePath())) {
            $datasetTransfer->setDatasetRowColumnValues(
                $this->reader->parseFileToDataTransfers($filePathTransfer),
            );
        }
        $this->entityManager->saveDataset($datasetTransfer);
    }

    public function activateDataset(DatasetTransfer $datasetTransfer): void
    {
        $this->entityManager->updateIsActiveDataset($datasetTransfer);
    }

    public function delete(DatasetTransfer $datasetTransfer): void
    {
        $this->entityManager->delete($datasetTransfer);
    }
}
