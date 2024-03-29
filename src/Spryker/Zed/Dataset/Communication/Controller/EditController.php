<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Communication\Controller;

use Generated\Shared\Transfer\DatasetFilePathTransfer;
use Generated\Shared\Transfer\DatasetTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Dataset\Business\Exception\DatasetParseException;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Dataset\Business\DatasetFacadeInterface getFacade()
 * @method \Spryker\Zed\Dataset\Communication\DatasetCommunicationFactory getFactory()
 * @method \Spryker\Zed\Dataset\Persistence\DatasetRepositoryInterface getRepository()
 */
class EditController extends AbstractController
{
    /**
     * @var string
     */
    protected const URL_PARAM_ID_DATASET = 'id-dataset';

    /**
     * @var string
     */
    protected const MESSAGE_DATASET_PARSE_ERROR = 'Something wrong';

    /**
     * @var string
     */
    protected const DATSET_LIST_URL = '/dataset';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $idDataset = $this->castId($request->query->get(static::URL_PARAM_ID_DATASET));
        $form = $this->getFactory()->getDatasetForm($idDataset)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datasetTransfer = $form->getData();
            $file = $form->get('contentFile')->getData();
            try {
                $this->saveDataset($datasetTransfer, $file);
                $redirectUrl = Url::generate(static::DATSET_LIST_URL)->build();

                return $this->redirectResponse($redirectUrl);
            } catch (DatasetParseException $e) {
                $this->addErrorMessage($e->getMessage());
            }
        }

        return $this->viewResponse([
            'form' => $form->createView(),
            'availableLocales' => $this->getFactory()->getLocaleFacade()->getLocaleCollection(),
            'currentLocale' => $this->getFactory()->getLocaleFacade()->getCurrentLocale(),
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\DatasetTransfer $datasetTransfer
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile|null $file
     *
     * @return void
     */
    protected function saveDataset(DatasetTransfer $datasetTransfer, ?UploadedFile $file = null): void
    {
        if ($file instanceof UploadedFile) {
            $filePathTransfer = new DatasetFilePathTransfer();
            /** @var string $realPath */
            $realPath = $file->getRealPath();
            $filePathTransfer->setFilePath($realPath);
            $this->getFacade()->save($datasetTransfer, $filePathTransfer);

            return;
        }

        $this->getFacade()->saveDataset($datasetTransfer);
    }
}
