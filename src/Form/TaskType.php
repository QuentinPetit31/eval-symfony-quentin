<?php

namespace App\Form;

use App\Entity\Task;
use Doctrine\DBAL\Types\DateTimeImmutableType as TypesDateTimeImmutableType;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutableType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('createdAt', TypesDateTimeImmutableType::class, [
                'widget' => 'single_text',
            ])
            ->add('expiredAt', DateTimeTzImmutableType::class, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
