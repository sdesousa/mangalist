<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\Admin\AdminAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/author")
 */
class AdminAuthorController extends AbstractController
{
    /**
     * @Route("/", name="admin_author_index", methods={"GET"})
     * @param AuthorRepository $authorRepository
     * @return Response
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/author/index.html.twig', [
            'authors' => $authorRepository->findBy([], ['lastname' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_author_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AdminAuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success', 'Votre auteur a été créé');
            return $this->redirectToRoute('admin_author_index');
        }

        return $this->render('admin/author/new.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_author_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Author $author
     * @return Response
     */
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AdminAuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre auteur a été modifié');
            return $this->redirectToRoute('admin_author_index');
        }

        return $this->render('admin/author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_author_delete", methods={"DELETE"})
     * @param Request $request
     * @param Author $author
     * @return Response
     */
    public function delete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($author);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre auteur a été supprimé');
        }

        return $this->redirectToRoute('admin_author_index');
    }
}
