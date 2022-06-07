<?php

namespace App\Form;

use App\Entity\TestReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tag')
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'input' => 'datetime_immutable',
                'time_widget' => 'single_text'
            ])
            // mapped => false es para que symfony no asocie este campo con la entidad
            ->add('file', FileType::class, array(
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'application/xml',
                            'text/xml'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid XML document',
                    ])
                ])
            )
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submit'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestReport::class,
        ]);
    }
}
