<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manga")
 */
class MangaController extends AbstractController
{
    /**
     * @Route("/", name="manga_index", methods={"GET"})
     */
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('manga/index.html.twig', [
            'mangas' => $mangaRepository->findBy([], ['title' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="manga_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $manga = new Manga();
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manga);
            $entityManager->flush();

            return $this->redirectToRoute('manga_index');
        }

        return $this->render('manga/new.html.twig', [
            'manga' => $manga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manga_show", methods={"GET"})
     */
    public function show(Manga $manga): Response
    {
        return $this->render('manga/show.html.twig', [
            'manga' => $manga,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="manga_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Manga $manga): Response
    {
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manga_index');
        }

        return $this->render('manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manga_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Manga $manga): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manga->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($manga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manga_index');
    }
}
