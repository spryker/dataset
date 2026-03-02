<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Persistence;

use Generated\Shared\Transfer\DatasetTransfer;

interface DatasetEntityManagerInterface
{
    public function updateIsActiveDataset(DatasetTransfer $datasetTransfer): void;

    public function delete(DatasetTransfer $datasetTransfer): void;

    public function saveDataset(DatasetTransfer $datasetTransfer): void;
}
