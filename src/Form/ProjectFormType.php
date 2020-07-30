<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Project title',
            ])
            ->add('currentPhpVersion', ChoiceType::class, [
                'label' => 'PHP Version',
                'placeholder' => 'Select a PHP version',
                'choices' => [
                    '5.6' => '5.6',
                    '7.0' => '7.0',
                    '7.1' => '7.1',
                    '7.2' => '7.2',
                    '7.3' => '7.3',
                    '7.4' => '7.4',
                ]
            ])
            ->add('currentFramework', ChoiceType::class, [
                'label' => 'Framework',
                'placeholder' => 'Select a framework',
                'choices' => [
                    'Symfony' => 'symfony',
                    'Phalcon' => 'phalcon',
                    'Laravel' => 'laravel',
                    'Nette' => 'nette',
                    'Zend' => 'zend'
                ]
            ])
            ->add('desiredPhpVersion', ChoiceType::class, [
                'label' => 'PHP Version',
                'placeholder' => 'Select a PHP version',
                'choices' => [
                    '5.6' => '5.6',
                    '7.0' => '7.0',
                    '7.1' => '7.1',
                    '7.2' => '7.2',
                    '7.3' => '7.3',
                    '7.4' => '7.4',
                ]
            ])
            ->add('desiredFramework', ChoiceType::class, [
                'label' => 'Framework',
                'placeholder' => 'Select the desired framework',
                'choices' => [
                    'Symfony' => 'symfony',
                    'Phalcon' => 'phalcon',
                    'Laravel' => 'laravel',
                    'Nette' => 'nette',
                    'Zend' => 'zend'
                ]
            ])
            ->add('save', SubmitType::class,[
                'attr' => [
                    'class' => 'mt-3 btn btn-dark btn-block',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
