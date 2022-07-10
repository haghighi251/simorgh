<?php

namespace App\Form;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
/*
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name',EntityType::class,[
                'class'=>Categories::class,
                'choice_label'=>'name',
            //'choices' => $this->userRepository->findAllEmailAlphabetical(),
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
