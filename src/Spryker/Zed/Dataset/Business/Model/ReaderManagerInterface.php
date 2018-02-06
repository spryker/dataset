<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Model;

interface ReaderManagerInterface
{
    /**
     * @param string $filePath
     *
     * @throws \Spryker\Zed\Dataset\Business\Exception\DatasetParseException
     *
     * @return \Generated\Shared\Transfer\SpyDatasetRowColumnValueEntityTransfer[]
     */
    public function convertFileToDataTransfers($filePath);
}