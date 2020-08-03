<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('currentFramework', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'Framework',
                'choices' => [
                    'Symfony' => 'Symfony',
                    'CodeIgniter' => 'CodeIgniter',
                    'Laravel' => 'Laravel',
                    'Zend' => 'Zend',
                    'Phalcon' => 'Phalcon',
                    'CakePHP' => 'CakePHP',
                    'Yii' => 'Yii',
                ],
            ])
            ->add('currentPhpVersion', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'PHP version',
                'choices' => [
                    '5.6' => '5.6',
                    '7.0' => '7.0',
                    '7.1' => '7.1',
                    '7.2' => '7.2',
                    '7.3' => '7.3',
                    '7.4' => '7.4',
                ],
            ])
            ->add('desiredFramework', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'Framework',
                'choices' => [
                    'Symfony' => 'Symfony',
                ],
            ])
            ->add('desiredPhpVersion', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'PHP version',
                'choices' => [
                    '7.4' => '7.4',
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-dark btn-block',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
