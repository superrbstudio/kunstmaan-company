<?php

namespace Superrb\KunstmaanCompanyBundle\Form\Type;

use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;

class CompanyAdminType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('companyName', TextType::class, [
            'required' => true,
        ])->add('description', TextareaType::class, [
            'required' => false,
        ])->add('streetAddress', TextType::class, [
            'required' => false,
        ])->add('addressLocality', TextType::class, [
            'required' => false,
        ])->add('addressRegion', TextType::class, [
            'required' => false,
        ])->add('postcode', TextType::class, [
            'required' => false,
        ])->add('addressCountry', CountryType::class, [
            'required' => false,
            'preferred_choices' => ['GB'],
        ])->add('lat', TextType::class, [
            'required' => false,
        ])->add('lng', TextType::class, [
            'required' => false,
        ])->add('facebook', TextType::class, [
            'label'    => 'Facebook URL',
            'required' => false,
        ])->add('twitter', TextType::class, [
            'label'    => 'Twitter URL',
            'required' => false,
        ])->add('instagram', TextType::class, [
            'label'    => 'Instagram URL',
            'required' => false,
        ])->add('youtube', TextType::class, [
            'label'    => 'Youtube URL',
            'required' => false,
        ])->add('vimeo', TextType::class, [
            'label'    => 'Vimeo URL',
            'required' => false,
        ])->add('pinterest', TextType::class, [
            'label'    => 'Pinterest URL',
            'required' => false,
        ])->add('linkedin', TextType::class, [
            'label'    => 'Linked In URL',
            'required' => false,
        ])->add('email', EmailType::class, [
            'required' => false,
        ])->add('phone', PhoneNumberType::class, [
            'required' => false,
            'attr'     => ['info_text' => 'Please enter the full international format (e.g. +44 20 1111 1111)'],
            'constraints' => [
                new PhoneNumber(),
            ],
        ])->add('logo', MediaType::class, [
            'required'    => false,
            'mediatype'   => 'image',
            'constraints' => [new Assert\Media([
                'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'],
            ])],
        ])->add('image', MediaType::class, [
            'required'    => false,
            'mediatype'   => 'image',
            'constraints' => [new Assert\Media([
                'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'],
            ])],
        ])->add('days', CollectionType::class, [
            'label'        => 'Opening Hours',
            'required'     => false,
            'entry_type'   => DayAdminType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            'attr'         => [
                'nested_form'           => true,
                'nested_form_min'       => 0,
                'nested_form_max'       => 14,
                'nested_sortable'       => true,
                'nested_sortable_field' => 'displayOrder',
            ],
        ])->add('submit', SubmitType::class, [
            'label' => 'Save',
            'attr'  => [
                'class' => 'btn btn-primary btn--raise-on-hover',
            ],
        ]);
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver the resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'company_form';
    }
}
