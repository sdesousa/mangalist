<?php

namespace App\Form\Admin;

use App\Entity\Editor;
use App\Entity\EditorCollection;
use App\Repository\EditorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEditorCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'label' => 'Editeur',
                'choice_label' => 'name',
                'query_builder' => function (EditorRepository $editorRepository) {
                    return $editorRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditorCollection::class,
        ]);
    }
}
