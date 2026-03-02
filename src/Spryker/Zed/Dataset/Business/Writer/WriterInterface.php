<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Writer;

use Generated\Shared\Transfer\DatasetTransfer;

interface WriterInterface
{
    public function getCsvByDataset(DatasetTransfer $datasetTransfer): string;
}
