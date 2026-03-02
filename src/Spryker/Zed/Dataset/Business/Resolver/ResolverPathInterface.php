<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Resolver;

use Generated\Shared\Transfer\DatasetFilenameTransfer;

interface ResolverPathInterface
{
    public function getFilenameByDatasetName(DatasetFilenameTransfer $datasetFilenameTransfer): DatasetFilenameTransfer;
}
