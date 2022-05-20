<?php

namespace App\Form;

use App\Entity\TestReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tag')
            ->add('tests')
            ->add('assertions')
            ->add('errors')
            ->add('warnings')
            ->add('failures')
            ->add('skipped')
            ->add('time')
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestReport::class,
        ]);
    }
}
