<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Business\Finder;

use Generated\Shared\Transfer\DatasetTransfer;
use Spryker\Zed\Dataset\Persistence\DatasetEntityManagerInterface;
use Spryker\Zed\Dataset\Persistence\DatasetRepositoryInterface;

class DatasetFinder implements DatasetFinderInterface
{
    /**
     * @var \Spryker\Zed\Dataset\Persistence\DatasetRepositoryInterface
     */
    protected $repository;

    /**
     * @var \Spryker\Zed\Dataset\Persistence\DatasetEntityManagerInterface
     */
    protected $entityManager;

    public function __construct(DatasetRepositoryInterface $repository, DatasetEntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function existsDatasetByName(DatasetTransfer $datasetTransfer): bool
    {
        return $this->repository->existsDatasetByName($datasetTransfer);
    }

    public function getDatasetModelById(DatasetTransfer $datasetTransfer): DatasetTransfer
    {
        return $this->repository->getDatasetByIdWithRelation($datasetTransfer);
    }

    public function getDatasetModelByName(DatasetTransfer $datasetTransfer): DatasetTransfer
    {
        return $this->repository->getDatasetByNameWithRelation($datasetTransfer);
    }
}
