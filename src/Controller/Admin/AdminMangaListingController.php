<?php

namespace App\Controller\Admin;

use App\Entity\MangaListing;
use App\Form\Admin\AdminMangaListingType;
use App\Repository\MangaListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mangalisting")
 */
class AdminMangaListingController extends AbstractController
{
    /**
     * @Route("/", name="admin_manga_listing_index", methods={"GET"})
     * @param MangaListingRepository $mlRepository
     * @return Response
     */
    public function index(MangaListingRepository $mlRepository): Response
    {
        return $this->render('admin/manga_listing/index.html.twig', [
            'mangaListings' => $mlRepository->findAllOrderByManga(),
        ]);
    }

    /**
     * @Route("/new", name="admin_manga_listing_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $mangaListing = new MangaListing();
        $form = $this->createForm(AdminMangaListingType::class, $mangaListing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mangaListing);
            $entityManager->flush();
            $this->addFlash('success', 'Votre listé a été créé');
            return $this->redirectToRoute('admin_manga_listing_index');
        }

        return $this->render('admin/manga_listing/new.html.twig', [
            'mangaListing' => $mangaListing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_manga_listing_edit", methods={"GET","POST"})
     * @param Request $request
     * @param MangaListing $mangaListing
     * @return Response
     */
    public function edit(Request $request, MangaListing $mangaListing): Response
    {
        $form = $this->createForm(AdminMangaListingType::class, $mangaListing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre listé a été modifié');
            return $this->redirectToRoute('admin_manga_listing_index');
        }

        return $this->render('admin/manga_listing/edit.html.twig', [
            'mangaListing' => $mangaListing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_manga_listing_delete", methods={"DELETE"})
     * @param Request $request
     * @param MangaListing $mangaListing
     * @return Response
     */
    public function delete(Request $request, MangaListing $mangaListing): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mangaListing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mangaListing);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre listé a été supprimé');
        }

        return $this->redirectToRoute('admin_manga_listing_index');
    }
}
