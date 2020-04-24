<?php

namespace App\Form\Admin;

use App\Entity\Editor;
use App\Entity\EditorCollection;
use App\Entity\Manga;
use App\Repository\EditorCollectionRepository;
use App\Repository\EditorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre'],
            ])
            ->add('totalVolume', IntegerType::class, [
                'label' => 'Volumes',
                'required' => false,
                'attr' => ['min' => 0, 'placeholder' => '0'],
            ])
            ->add('availableVolume', IntegerType::class, [
                'label' => 'Disponible',
                'required' => false,
                'attr' => ['min' => 0, 'placeholder' => '0'],
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'required' => false,
                'attr' => ['min' => 1900, 'placeholder' => '1900'],
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'label' => 'Editeur',
                'choice_label' => 'name',
                'placeholder' => '-',
                'query_builder' => function (EditorRepository $editorRepository) {
                    return $editorRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
            ])
            ->add('editorCollection', EntityType::class, [
                'class' => EditorCollection::class,
                'label' => 'Collection',
                'choice_label' => 'name',
                'placeholder' => '-',
                'query_builder' => function (EditorCollectionRepository $editorCollectionRepository) {
                    return $editorCollectionRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
            ])
            ->add('mangaAuthors', CollectionType::class, [
                'entry_type' => AdminMangaAuthorType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
