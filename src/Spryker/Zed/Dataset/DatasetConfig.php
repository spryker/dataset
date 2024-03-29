<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset;

use Spryker\Shared\Dataset\DatasetConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class DatasetConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const DEFAULT_SIZE = '1M';

    /**
     * @api
     *
     * @return string
     */
    public function getMaxFileSize(): string
    {
        return $this->getConfig()->hasValue(DatasetConstants::DATASET_FILE_SIZE) ?
            $this->getConfig()->get(DatasetConstants::DATASET_FILE_SIZE) : static::DEFAULT_SIZE;
    }
}
