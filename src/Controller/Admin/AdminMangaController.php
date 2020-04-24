<?php

namespace App\Controller\Admin;

use App\Entity\Manga;
use App\Entity\MangaAuthor;
use App\Form\Admin\AdminMangaType;
use App\Repository\AuthorRepository;
use App\Repository\AuthorRoleRepository;
use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/manga")
 */
class AdminMangaController extends AbstractController
{
    /**
     * @Route("/", name="admin_manga_index", methods={"GET"})
     * @param MangaRepository $mangaRepository
     * @return Response
     */
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('admin/manga/index.html.twig', [
            'mangas' => $mangaRepository->findBy([], ['title' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_manga_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $manga = new Manga();
        $form = $this->createForm(AdminMangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manga);
            $entityManager->flush();
            $this->addFlash('success', 'Votre manga a été créée');
            return $this->redirectToRoute('admin_manga_index');
        }

        return $this->render('admin/manga/new.html.twig', [
            'manga' => $manga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_manga_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Manga $manga
     * @return Response
     */
    public function edit(Request $request, Manga $manga): Response
    {
        $form = $this->createForm(AdminMangaType::class, $manga);

        $originalsMangaAuthors = new ArrayCollection();
        foreach ($manga->getMangaAuthors() as $mangaAuthor) {
            $originalsMangaAuthors->add($mangaAuthor);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            var_dump($form->getData()->getMangaAuthors());
//            die();
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($originalsMangaAuthors as $originalsMangaAuthor) {
                if(false === $manga->getMangaAuthors()->contains($originalsMangaAuthor)) {
                    $entityManager->remove($originalsMangaAuthor);
                }
            }
            $entityManager->persist($manga);
            $entityManager->flush();
            $this->addFlash('success', 'Votre manga a été modifiée');
            return $this->redirectToRoute('admin_manga_index');
        }

        return $this->render('admin/manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_manga_delete", methods={"DELETE"})
     * @param Request $request
     * @param Manga $manga
     * @return Response
     */
    public function delete(Request $request, Manga $manga): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manga->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $mangaAuthors = $manga->getMangaAuthors();
            if(!empty($mangaAuthors)) {
                foreach ($mangaAuthors as $mangaAuthor) {
                    $entityManager->remove($mangaAuthor);
                }
            }
            $entityManager->remove($manga);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre manga a été supprimée');
        }

        return $this->redirectToRoute('admin_manga_index');
    }
}
