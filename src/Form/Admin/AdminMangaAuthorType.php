<?php

namespace App\Form\Admin;

use App\Entity\Author;
use App\Entity\AuthorRole;
use App\Entity\MangaAuthor;
use App\Repository\AuthorRepository;
use App\Repository\AuthorRoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMangaAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'label' => 'Auteur',
                'choice_label' => 'fullname',
                'placeholder' => '-',
                'query_builder' => function (AuthorRepository $authorRepository) {
                    return $authorRepository->createQueryBuilder('e')
                        ->orderBy('e.lastname', 'ASC');
                },
            ])
            ->add('role', EntityType::class, [
                'class' => AuthorRole::class,
                'label' => 'Rôle',
                'choice_label' => 'role',
                'placeholder' => '-',
                'query_builder' => function (AuthorRoleRepository $authorRoleRepository) {
                    return $authorRoleRepository->createQueryBuilder('e')
                        ->orderBy('e.role', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MangaAuthor::class,
        ]);
    }
}
