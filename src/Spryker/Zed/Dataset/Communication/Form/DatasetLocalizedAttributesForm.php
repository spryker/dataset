<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Communication\Form;

use Generated\Shared\Transfer\DatasetLocalizedAttributeTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\Dataset\DatasetConfig getConfig()
 * @method \Spryker\Zed\Dataset\Persistence\DatasetRepositoryInterface getRepository()
 * @method \Spryker\Zed\Dataset\Business\DatasetFacadeInterface getFacade()
 * @method \Spryker\Zed\Dataset\Communication\DatasetCommunicationFactory getFactory()
 */
class DatasetLocalizedAttributesForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_TITLE = 'title';

    /**
     * @var string
     */
    public const FIELD_LOCALE_NAME = 'localeName';

    /**
     * @var string
     */
    public const FIELD_FK_LOCALE = 'fkLocale';

    /**
     * @var string
     */
    public const FIELD_ID_DATASET_LOCALIZED_ATTRIBUTES = 'idDatasetLocalizedAttributes';

    /**
     * @var string
     */
    public const OPTION_DATA_CLASS = 'data_class';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdDatasetLocalizedAttributes($builder)
            ->addTitleField($builder)
            ->addFkLocaleField($builder)
            ->addDatasetLocaleNameField($builder);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(DatasetForm::OPTION_AVAILABLE_LOCALES);
        $resolver->setDefaults([
            static::OPTION_DATA_CLASS => DatasetLocalizedAttributeTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDatasetLocaleNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LOCALE_NAME, HiddenType::class, [
            'constraints' => [
                new NotBlank(),
            ],
            'property_path' => 'locale.localeName',
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addTitleField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_TITLE, TextType::class, [
            'label' => 'Title',
            'required' => true,
            'constraints' => [
                new Length(['max' => 255]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFkLocaleField(FormBuilderInterface $builder)
    {
        $builder
            ->add(static::FIELD_FK_LOCALE, HiddenType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'property_path' => 'locale.idLocale',
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdDatasetLocalizedAttributes(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_DATASET_LOCALIZED_ATTRIBUTES, HiddenType::class);

        return $this;
    }
}
