<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\{
    AbstractType, Extension\Core\Type\CheckboxType, Extension\Core\Type\DateTimeType,
    Extension\Core\Type\SubmitType,
    Extension\Core\Type\TextType, Extension\Core\Type\UrlType, FormBuilderInterface
};
use Symfony\Component\OptionsResolver\OptionsResolver;



class RedirectRuleType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, ['required' => false])
            ->add('url', UrlType::class, ['required' => true])
            ->add('expired', DateTimeType::class, ['required' => false])
            ->add('submit', SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'entity_manager' => true,
            'cascade_validation' => false,
            'csrf_protection' => true,
            'data_class' => 'AppBundle\Entity\RedirectRule'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'redirect_rule_type';
    }
}