<?php

namespace Superrb\KunstmaanCompanyBundle\Form\Type;

use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Superrb\KunstmaanCompanyBundle\Entity\Address;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Url;

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
        ])->add('defaultAddress', EntityType::class, [
            'required'     => false,
            'class'        => Address::class,
            'choice_label' => function (Address $address): string {
                return $address->getName() ?? $address->getAddress();
            },
        ])->add('facebook', TextType::class, [
            'label'       => 'Facebook URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('twitter', TextType::class, [
            'label'       => 'Twitter URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('instagram', TextType::class, [
            'label'       => 'Instagram URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('youtube', TextType::class, [
            'label'       => 'Youtube URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('vimeo', TextType::class, [
            'label'       => 'Vimeo URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('pinterest', TextType::class, [
            'label'       => 'Pinterest URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('linkedin', TextType::class, [
            'label'       => 'Linked In URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('dribbble', TextType::class, [
            'label'       => 'Dribbble URL',
            'required'    => false,
            'constraints' => [
                new Url(),
            ],
        ])->add('email', EmailType::class, [
            'required'    => false,
            'constraints' => [
                new Email(),
            ],
        ])->add('phone', PhoneNumberType::class, [
            'required'    => false,
            'attr'        => ['info_text' => 'Please enter the full international format (e.g. +44 20 1111 1111)'],
            'constraints' => [
                new PhoneNumber(),
            ],
        ])->add('logo', MediaType::class, [
            'required'    => true,
            'mediatype'   => 'image',
            'constraints' => [new Assert\Media([
                'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/svg'],
            ])],
        ])->add('image', MediaType::class, [
            'required'    => true,
            'mediatype'   => 'image',
            'constraints' => [new Assert\Media([
                'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/svg'],
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
