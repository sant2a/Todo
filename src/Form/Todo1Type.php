<?php

namespace App\Form;

use App\Entity\Todo1;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Todo1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, array('attr' => array(
                'class' => 'form-control',
                'title' => 'Enter the task name',
                'choice_label' => 'email',
            )))
            ->add('description', TextareaType::class, array('attr' => array(
                'class' => 'form-control',
                'title' => 'Enter the description',
            )))
            ->add('priority', ChoiceType::class, array(
                'choices' => array(
                    '1'       => '1',
                    '2'    => '2',
                    '3'      => '3'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'title' => 'Select the priority',
                )
            ))
            ->add('created_at',DateTimeType::class, array('attr' => array(

                'title' => 'Select the create date')))

            ->add('save', SubmitType::class, array(

                'label' => 'Создать',
                'attr' => array(
                    'class' => 'btn btn-primary',
                    'title' => 'Create task'
                )
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todo1::class,
        ]);
    }


}
