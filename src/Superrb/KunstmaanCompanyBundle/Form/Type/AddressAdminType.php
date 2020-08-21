<?php

namespace Superrb\KunstmaanCompanyBundle\Form\Type;

use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * The type for Address.
 */
class AddressAdminType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'required' => false,
        ]);
        $builder->add('streetAddress', TextType::class, [
            'required'    => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('locality', TextType::class, [
            'required'    => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('region', TextType::class, [
            'required' => false,
        ]);
        $builder->add('postcode', TextType::class, [
            'required' => false,
        ]);
        $builder->add('country', CountryType::class, [
            'required'          => false,
            'preferred_choices' => ['GB'],
        ]);
        $builder->add('url', UrlType::class, [
            'required' => false,
        ]);
        $builder->add('email', EmailType::class, [
            'required'    => false,
            'constraints' => [
                new Email(),
            ],
        ]);
        $builder->add('phone', PhoneNumberType::class, [
            'required'    => false,
            'attr'        => ['info_text' => 'Please enter the full international format (e.g. +44 20 1111 1111)'],
            'constraints' => [
                new PhoneNumber(),
            ],
        ]);
        $builder->add('lat', TextType::class, [
            'required' => false,
        ]);
        $builder->add('lng', TextType::class, [
            'required' => false,
        ]);
        $builder->add('displayOrder', IntegerType::class, [
            'required' => true,
        ]);
        $builder->add('company', EntityType::class, [
            'required'     => true,
            'class'        => Company::class,
            'choice_label' => 'companyName',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'address_form';
    }
}
