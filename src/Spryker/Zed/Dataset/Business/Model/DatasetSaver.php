<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Model;

use Generated\Shared\Transfer\SpyDatasetEntityTransfer;
use Orm\Zed\Dataset\Persistence\SpyDataset;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

class DatasetSaver implements DatasetSaverInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @var \Spryker\Zed\Dataset\Business\Model\DatasetFinderInterface
     */
    protected $datasetFinder;

    /**
     * @var \Spryker\Zed\Dataset\Business\Model\DatasetLocalizedAttributesSaverInterface
     */
    protected $datasetLocalizedAttributesSaver;

    /**
     * @var \Spryker\Zed\Dataset\Business\Model\DatasetRowColumnValueSaverInterface
     */
    protected $datasetRowColumnValueSaver;

    /**
     * @var \Spryker\Zed\Dataset\Business\Model\ReaderManagerInterface
     */
    protected $readerManager;

    /**
     * @param \Spryker\Zed\Dataset\Business\Model\DatasetFinderInterface $datasetFinder
     * @param \Spryker\Zed\Dataset\Business\Model\DatasetLocalizedAttributesSaverInterface $datasetLocalizedAttributesSaver
     * @param \Spryker\Zed\Dataset\Business\Model\DatasetRowColumnValueSaverInterface $datasetRowColumnValueSaver
     * @param \Spryker\Zed\Dataset\Business\Model\ReaderManagerInterface $readerManager
     */
    public function __construct(
        DatasetFinderInterface $datasetFinder,
        DatasetLocalizedAttributesSaverInterface $datasetLocalizedAttributesSaver,
        DatasetRowColumnValueSaverInterface $datasetRowColumnValueSaver,
        ReaderManagerInterface $readerManager
    ) {
        $this->datasetFinder = $datasetFinder;
        $this->datasetLocalizedAttributesSaver = $datasetLocalizedAttributesSaver;
        $this->datasetRowColumnValueSaver = $datasetRowColumnValueSaver;
        $this->readerManager = $readerManager;
    }

    /**
     * @param null|\Generated\Shared\Transfer\SpyDatasetEntityTransfer $saveRequestTransfer
     * @param string|null $filePath
     *
     * @return bool
     */
    public function save(SpyDatasetEntityTransfer $saveRequestTransfer, $filePath = null)
    {
        if (!empty($filePath) && file_exists($filePath)) {
            $saveRequestTransfer->setSpyDatasetRowColumnValues(
                $this->readerManager->convertFileToDataTransfers($filePath)
            );
        }
        if ($this->checkDatasetExists($saveRequestTransfer)) {
            $this->update($saveRequestTransfer);

            return true;
        }
        $this->create($saveRequestTransfer);

        return true;
    }

    /**
     * @param \Orm\Zed\Dataset\Persistence\SpyDataset $dataset
     * @param \Generated\Shared\Transfer\SpyDatasetEntityTransfer $saveRequestTransfer
     *
     * @return void
     */
    protected function saveDataset(SpyDataset $dataset, SpyDatasetEntityTransfer $saveRequestTransfer)
    {
        $this->handleDatabaseTransaction(function () use ($dataset, $saveRequestTransfer) {
            $dataset->fromArray($saveRequestTransfer->toArray());
            if ($saveRequestTransfer->getSpyDatasetRowColumnValues()->count() && !$dataset->isNew()) {
                $this->datasetRowColumnValueSaver->removeDatasetRowColumnValues($dataset);
            }
            $dataset->save();
            $this->datasetLocalizedAttributesSaver->saveDatasetLocalizedAttributes($dataset, $saveRequestTransfer);
            $this->datasetRowColumnValueSaver->saveDatasetRowColumnValues($dataset, $saveRequestTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\SpyDatasetEntityTransfer $saveRequestTransfer
     *
     * @return void
     */
    protected function update(SpyDatasetEntityTransfer $saveRequestTransfer)
    {
        $dataset = $this->datasetFinder->getDatasetId($saveRequestTransfer->getIdDataset());

        $this->saveDataset($dataset, $saveRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SpyDatasetEntityTransfer $saveRequestTransfer
     *
     * @return void
     */
    protected function create(SpyDatasetEntityTransfer $saveRequestTransfer)
    {
        $dataset = new SpyDataset();

        $this->saveDataset($dataset, $saveRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SpyDatasetEntityTransfer $saveRequestTransfer
     *
     * @return bool
     */
    protected function checkDatasetExists(SpyDatasetEntityTransfer $saveRequestTransfer)
    {
        $idDataset = $saveRequestTransfer->getIdDataset();
        if ($idDataset === null) {
            return false;
        }
        $dataset = $this->datasetFinder->getDatasetId($idDataset);

        return $dataset !== null;
    }
}