<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Dependency\Adapter;

use Iterator;
use League\Csv\Reader;

class CsvReaderAdapter implements CsvReaderInterface
{
    /**
     * @var \League\Csv\Reader<array<string, string>>
     */
    protected $reader;

    public function __construct(string $path, string $mode)
    {
        $this->reader = Reader::createFromPath($path, $mode ?: 'r');
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setHeaderOffset(int $offset)
    {
        $this->reader->setHeaderOffset($offset);

        return $this;
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->reader->getHeader();
    }

    public function getRecords(): Iterator
    {
        return $this->reader->getRecords();
    }
}
