<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Finder;

use Generated\Shared\Transfer\DatasetTransfer;

interface DatasetFinderInterface
{
    public function existsDatasetByName(DatasetTransfer $datasetTransfer): bool;

    public function getDatasetModelById(DatasetTransfer $datasetTransfer): DatasetTransfer;

    public function getDatasetModelByName(DatasetTransfer $datasetTransfer): DatasetTransfer;
}
