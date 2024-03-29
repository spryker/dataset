<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Dataset\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DatasetFilenameTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Dataset
 * @group Business
 * @group Model
 * @group ResolverPathTest
 * Add your own group annotations below this line
 */
class ResolverPathTest extends Unit
{
    /**
     * @var string
     */
    public const DEFAULT_FILENAME = 'dataset';

    /**
     * @var \SprykerTest\Zed\Dataset\DatasetBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testGetFilenameByDatasetNameWillReturnDefaultFilename(): void
    {
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('.'),
            )->getFilename(),
            static::DEFAULT_FILENAME,
        );
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('.!+*.'),
            )->getFilename(),
            static::DEFAULT_FILENAME,
        );
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('%    % .. ... ?='),
            )->getFilename(),
            static::DEFAULT_FILENAME,
        );
    }

    /**
     * @return void
     */
    public function testGetFilenameByDatasetNameWillReturnValidFilename(): void
    {
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer(' Extra         Spaces   123 '),
            )->getFilename(),
            'Extra Spaces 123',
        );
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('Bad/Good Example'),
            )->getFilename(),
            'BadGood Example',
        );
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('already-valid-name'),
            )->getFilename(),
            'already-valid-name',
        );
        $this->assertSame(
            $this->tester->getLocator()->dataset()->facade()->getFilenameByDatasetName(
                $this->buildDatasetFilenameTransfer('Unacceptable Symbols / %?.. .?. ! \ '),
            )->getFilename(),
            'Unacceptable Symbols',
        );
    }

    /**
     * @param string $filename
     *
     * @return \Generated\Shared\Transfer\DatasetFilenameTransfer
     */
    protected function buildDatasetFilenameTransfer(string $filename): DatasetFilenameTransfer
    {
        $datasetFilenameTransfer = new DatasetFilenameTransfer();
        $datasetFilenameTransfer->setFilename($filename);

        return $datasetFilenameTransfer;
    }
}
