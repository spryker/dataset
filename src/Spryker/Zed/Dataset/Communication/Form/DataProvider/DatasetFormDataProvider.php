<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Communication\Form\DataProvider;

use Generated\Shared\Transfer\SpyDatasetEntityTransfer;
use Generated\Shared\Transfer\SpyDatasetLocalizedAttributesEntityTransfer;
use Generated\Shared\Transfer\SpyLocaleEntityTransfer;
use Orm\Zed\Dataset\Persistence\SpyDataset;
use Spryker\Zed\Dataset\Communication\Form\DatasetForm;
use Spryker\Zed\Dataset\Dependency\Facade\DatasetToLocaleFacadeFacadeBridge;
use Spryker\Zed\Dataset\Persistence\DatasetQueryContainerInterface;

class DatasetFormDataProvider
{
    const FK_LOCALE_KEY = 'fkLocale';

    /**
     * @var \Spryker\Zed\Dataset\Persistence\DatasetQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Spryker\Zed\Dataset\Dependency\Facade\DatasetToLocaleFacadeFacadeBridge
     */
    protected $localeFacade;

    /**
     * @param \Spryker\Zed\Dataset\Persistence\DatasetQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Dataset\Dependency\Facade\DatasetToLocaleFacadeFacadeBridge
     */
    public function __construct(
        DatasetQueryContainerInterface $queryContainer,
        DatasetToLocaleFacadeFacadeBridge $localeFacade
    ) {
        $this->queryContainer = $queryContainer;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param int|null $idDataset
     *
     * @return \Generated\Shared\Transfer\SpyDatasetEntityTransfer
     */
    public function getData($idDataset = null)
    {
        if ($idDataset === null) {
            return $this->createEmptyspyDatasetTransfer();
        }
        $spyDataset = $this
            ->queryContainer
            ->queryDatasetById($idDataset)
            ->leftJoinWithSpyDatasetRowColValue()
            ->find()
            ->getFirst();

        $spyDatasetTransfer = $this->createEmptyspyDatasetTransfer();
        $this->addSpyDatasetLocalizedAttributeTransfers($spyDataset, $spyDatasetTransfer);
        $spyDatasetTransfer->fromArray($spyDataset->toArray(), true);

        return $spyDatasetTransfer;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            DatasetForm::OPTION_AVAILABLE_LOCALES => $this->getAvailableLocales(),
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer[]
     */
    protected function getAvailableLocales()
    {
        return $this->localeFacade
            ->getLocaleCollection();
    }

    /**
     * @return \Generated\Shared\Transfer\SpyDatasetEntityTransfer
     */
    protected function createEmptyspyDatasetTransfer()
    {
        $spyDatasetTransfer = new SpyDatasetEntityTransfer();
        foreach ($this->getAvailableLocales() as $locale) {
            $spyLocalEntityTransfer = new SpyLocaleEntityTransfer();
            $spyLocalEntityTransfer->fromArray($locale->toArray());
            $spyDatasetLocalizedAttributeTransfer = new SpyDatasetLocalizedAttributesEntityTransfer();
            $spyDatasetLocalizedAttributeTransfer->setLocale($spyLocalEntityTransfer);
            $spyDatasetTransfer->addSpyDatasetLocalizedAttributess($spyDatasetLocalizedAttributeTransfer);
        }

        return $spyDatasetTransfer;
    }

    /**
     * @param \Orm\Zed\Dataset\Persistence\SpyDataset $spyDataset
     * @param \Generated\Shared\Transfer\SpyDatasetEntityTransfer $spyDatasetTransfer
     *
     * @return void
     */
    protected function addSpyDatasetLocalizedAttributeTransfers(
        SpyDataset $spyDataset,
        SpyDatasetEntityTransfer $spyDatasetTransfer
    ) {
        $savedLocalizedAttributes = $spyDataset->getSpyDatasetLocalizedAttributess()
            ->toKeyIndex(static::FK_LOCALE_KEY);
        foreach ($spyDatasetTransfer->getSpyDatasetLocalizedAttributess() as $spyDatasetLocalizedAttributeTransfer) {
            $fkLocale = $spyDatasetLocalizedAttributeTransfer->getLocale()->getIdLocale();
            if (!empty($savedLocalizedAttributes[$fkLocale])) {
                $spyDatasetLocalizedAttributeTransfer->fromArray($savedLocalizedAttributes[$fkLocale]->toArray());
            }
        }
    }
}
