<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array(
                'class' => 'form-control',
                'title' => 'Enter the task name',
            )))
            ->add('description', TextareaType::class, array('attr' => array(
                'class' => 'form-control',
                'title' => 'Enter the description',
            )))
            ->add('priority', ChoiceType::class, array(
                'choices' => array(
                    'Low'       => 'Low',
                    'Normal'    => 'Normal',
                    'High'      => 'High'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'title' => 'Select the priority',
                )
            ))
            ->add('created_at',DateTimeType::class, array('attr' => array(
        'class' => 'form-control',
        'title' => 'Select the create date')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create task',
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
            'data_class' => Todo::class,
        ]);
    }
}
