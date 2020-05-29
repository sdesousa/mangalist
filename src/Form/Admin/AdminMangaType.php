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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMangaType extends AbstractType
{
    /**
     * @var EditorRepository
     */
    private $editorRepository;
    /**
     * @var EditorCollectionRepository
     */
    private $collectionRepository;

    /**
     * AdminMangaType constructor.
     * @param EditorRepository $editorRepository
     * @param EditorCollectionRepository $collectionRepository
     */
    public function __construct(
        EditorRepository $editorRepository,
        EditorCollectionRepository $collectionRepository
    ) {
        $this->editorRepository = $editorRepository;
        $this->collectionRepository = $collectionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
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
            ->add('mangaAuthors', CollectionType::class, [
                'entry_type' => AdminMangaAuthorType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Editor $editor = null): void
    {
        $form->add('editor', EntityType::class, [
            'class' => Editor::class,
            'label' => 'Editeur',
            'choice_label' => 'name',
            'placeholder' => '-',
            'query_builder' => function (EditorRepository $editorRepository) {
                return $editorRepository->createQueryBuilder('e')
                    ->orderBy('e.name', 'ASC');
            },
        ]);
        $editorCollections = [];
        if ($editor) {
            $editorCollections = $this->collectionRepository->createQueryBuilder("c")
                ->where("c.editor = :editorId")
                ->setParameter("editorId", $editor->getId())
                ->orderBy('c.name', 'ASC')
                ->getQuery()
                ->getResult();
        }
        $form->add('editorCollection', EntityType::class, [
            'class' => EditorCollection::class,
            'label' => 'Collection',
            'choices' => $editorCollections,
            'choice_label' => 'name',
            'placeholder' => '-',
        ]);
    }

    public function onPreSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();

        $editor = $this->editorRepository->find($data['editor']);

        $this->addElements($form, $editor);
    }

    public function onPreSetData(FormEvent $event): void
    {
        $manga = $event->getData();
        $form = $event->getForm();

        $editor = $manga->getEditor() ? $manga->getEditor() : null;

        $this->addElements($form, $editor);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manga::class,
        ]);
    }
}
