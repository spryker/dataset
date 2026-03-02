<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Dataset\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DatasetFilenameTransfer;
use Generated\Shared\Transfer\DatasetTransfer;
use Spryker\Zed\Dataset\Business\Exception\DatasetNotFoundException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Dataset
 * @group Business
 * @group DatasetTest
 * Add your own group annotations below this line
 */
class DatasetTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\Dataset\DatasetBusinessTester
     */
    protected $tester;

    public function testSavesCsvData(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);

        $this->assertInstanceOf(DatasetTransfer::class, $datasetTransfer);
        $this->assertNotNull($datasetTransfer->getIdDataset());
        $this->assertSame($datasetEntityTransfer->getName(), $datasetTransfer->getName());
    }

    public function testSaveDataset(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);

        $this->assertInstanceOf(DatasetTransfer::class, $datasetTransfer);
        $this->assertNotNull($datasetTransfer->getIdDataset());
        $this->assertSame($datasetEntityTransfer->getName(), $datasetTransfer->getName());
    }

    public function testExistingDatasetName(): void
    {
        $datasetTransfer = $this->tester->createDatasetTransfer();
        $this->tester->getLocator()->dataset()->facade()->save($datasetTransfer, $this->tester->createDatasetFilePathTransfer());
        $dashboardExist = $this->tester->getLocator()->dataset()->facade()->existsDatasetByName($datasetTransfer);

        $this->assertTrue($dashboardExist);
    }

    public function testCsvByDataset(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $this->tester->getLocator()->dataset()->facade()->save($datasetEntityTransfer, $this->tester->createDatasetFilePathTransfer());
        $datasetTransfer = $this->tester->getLocator()->dataset()->facade()->getDatasetModelByName($datasetEntityTransfer);

        $dataContent = $this->tester->getLocator()->dataset()->facade()->getCsvByDataset($datasetTransfer);
        $originalFileContent = file_get_contents($this->tester->createDatasetFilePathTransfer()->getFilePath());

        $this->assertSame($dataContent, $originalFileContent);
    }

    public function testExistingDatasetById(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);
        $datasetTransfer = $this->tester->getLocator()->dataset()->facade()->getDatasetModelById($datasetTransfer);

        $this->assertInstanceOf(DatasetTransfer::class, $datasetTransfer);
        $this->assertNotNull($datasetTransfer->getIdDataset());
        $this->assertSame($datasetEntityTransfer->getName(), $datasetTransfer->getName());
    }

    public function testExistingDatasetByName(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);

        $this->assertInstanceOf(DatasetTransfer::class, $datasetTransfer);
        $this->assertNotNull($datasetTransfer->getIdDataset());
        $this->assertSame($datasetEntityTransfer->getName(), $datasetTransfer->getName());
    }

    public function testDeleteDataset(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);
        $datasetId = $datasetTransfer->getIdDataset();
        $this->tester->getLocator()->dataset()->facade()->delete((new DatasetTransfer())->setIdDataset($datasetId));

        $this->expectException(DatasetNotFoundException::class);

        $this->tester->getLocator()->dataset()->facade()->getDatasetModelById((new DatasetTransfer())->setIdDataset($datasetId));
    }

    public function testActivateDataset(): void
    {
        $datasetEntityTransfer = $this->tester->createDatasetTransfer();
        $datasetTransfer = $this->saveDatasetByTransfer($datasetEntityTransfer);
        $this->tester->getLocator()->dataset()->facade()->activateDataset($datasetTransfer->setIsActive(true));
        $datasetTransfer = $this->tester->getLocator()->dataset()->facade()->getDatasetModelById($datasetTransfer);

        $this->assertTrue($datasetTransfer->getIsActive());
    }

    public function testGetFilenameByDatasetNameReturnsValidTransfer(): void
    {
        $datasetFilenameTransfer = $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
            (new DatasetFilenameTransfer())->setFilename('some name'),
        );

        $this->assertInstanceOf(DatasetFilenameTransfer::class, $datasetFilenameTransfer);
        $this->assertNotEmpty($datasetFilenameTransfer->getFilename());
    }

    protected function saveDatasetByTransfer(DatasetTransfer $datasetEntityTransfer): DatasetTransfer
    {
        $this->tester->getLocator()->dataset()->facade()->saveDataset($datasetEntityTransfer);

        return $this->tester->getLocator()->dataset()->facade()->getDatasetModelByName($datasetEntityTransfer);
    }
}
