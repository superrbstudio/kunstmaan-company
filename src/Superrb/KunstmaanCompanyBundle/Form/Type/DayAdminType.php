<?php

namespace Superrb\KunstmaanCompanyBundle\Form\Type;

use Superrb\KunstmaanCompanyBundle\Entity\Day;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The type for Day.
 */
class DayAdminType extends AbstractType
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
        $builder->add('day', ChoiceType::class, [
            'required'          => true,
            'choices'           => [
                'Sunday'   => 'Sunday',
                'Monday'   => 'Monday',
                'Tuesday'  => 'Tuesday',
                'Wednesday'=> 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday'   => 'Friday',
                'Saturday' => 'Saturday',
            ],
        ])
        ->add('openTime', TextType::class, [
            'required' => true,
        ])
        ->add('closeTime', TextType::class, [
            'required' => true,
        ])
        ->add('displayOrder', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => Day::class,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'day_form';
    }
}
