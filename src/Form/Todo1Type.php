<?php

namespace App\Form;

use App\Entity\Todo1;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Todo1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', EntityType::class, [
                'label' => "Автор",
                'required' => true,
                'class' => User::class,
                'choice_label' => 'email'])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => "Задача:",
                'attr' => [
                    'placeholder' => 'введите название задачи '
                ]
            ])
            ->add('description', TextType::class,[
                'label' => "Описание",
                'required' => true,

            ])
            ->add('priority', ChoiceType::class, array(
                'label' => "Приоритет",
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
            ->add('created_at',DateTimeType::class, [
                'required' => true,
                'label' => "Дата создания",
               ])

            ->add('save', SubmitType::class, array(

                'label' => 'Сохранить',
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
