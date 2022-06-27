<?php

namespace App\Form;

use App\Entity\VisitReport;
use App\Entity\VisitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('visitType', EntityType::class, [
                'class' => VisitType::class,
                'multiple' => false,
                'expanded' => true,
                'by_reference' => false
            ])
            // ->add('values', CollectionType::class, [
            //     'entry_type' => VisitValueType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VisitReport::class,
        ]);
    }
}
