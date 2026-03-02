<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\CsvFactory;

use SplFileObject;
use Spryker\Zed\Dataset\Dependency\Adapter\CsvReaderAdapter;
use Spryker\Zed\Dataset\Dependency\Adapter\CsvReaderInterface;
use Spryker\Zed\Dataset\Dependency\Adapter\CsvWriterAdapter;
use Spryker\Zed\Dataset\Dependency\Adapter\CsvWriterInterface;

class CsvFactory
{
    public function createCsvReader(string $path, string $mode): CsvReaderInterface
    {
        return new CsvReaderAdapter($path, $mode);
    }

    public function createCsvWriter(SplFileObject $splFileObject): CsvWriterInterface
    {
        return new CsvWriterAdapter($splFileObject);
    }
}
