<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Persistence;

use Generated\Shared\Transfer\DatasetTransfer;

interface DatasetRepositoryInterface
{
    public function existsDatasetById(DatasetTransfer $datasetTransfer): bool;

    public function existsDatasetByName(DatasetTransfer $datasetTransfer): bool;

    public function getDatasetByIdWithRelation(DatasetTransfer $datasetTransfer): DatasetTransfer;

    public function getDatasetByNameWithRelation(DatasetTransfer $datasetTransfer): DatasetTransfer;
}
