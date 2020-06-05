<?php

namespace App\Form\Admin;

use App\Entity\Listing;
use App\Entity\Manga;
use App\Entity\MangaListing;
use App\Repository\MangaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMangaListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('listing', EntityType::class, [
                'class' => Listing::class,
                'label' => 'Liste',
                'choice_label' => 'id',
                'placeholder' => '-',
            ])
            ->add('manga', EntityType::class, [
                'class' => Manga::class,
                'label' => 'Manga',
                'choice_label' => 'title',
                'placeholder' => '-',
                'query_builder' => function (MangaRepository $mangaRepository) {
                    return $mangaRepository->createQueryBuilder('m')
                        ->orderBy('m.title', 'ASC');
                },
            ])
            ->add('possessedVolume', IntegerType::class, [
                'label' => 'Volumes',
                'attr' => ['min' => 1, 'placeholder' => '1'],
            ])
            ->add('remark', TextareaType::class, [
                'label' => 'Remarque',
                'required' => false,
                'attr' => ['placeholder' => 'Remarque'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MangaListing::class,
        ]);
    }
}
