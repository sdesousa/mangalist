<?php

namespace App\Controller\Admin;

use App\Entity\AuthorRole;
use App\Form\Admin\AdminAuthorRoleType;
use App\Repository\AuthorRoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/role")
 */
class AdminAuthorRoleController extends AbstractController
{
    /**
     * @Route("/", name="admin_author_role_index", methods={"GET"})
     * @param AuthorRoleRepository $authorRoleRepository
     * @return Response
     */
    public function index(AuthorRoleRepository $authorRoleRepository): Response
    {
        return $this->render('admin/author_role/index.html.twig', [
            'authorRoles' => $authorRoleRepository->findBy([], ['role' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_author_role_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $authorRole = new AuthorRole();
        $form = $this->createForm(AdminAuthorRoleType::class, $authorRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($authorRole);
            $entityManager->flush();
            $this->addFlash('success', 'Votre rôle a été créé');
            return $this->redirectToRoute('admin_author_role_index');
        }

        return $this->render('admin/author_role/new.html.twig', [
            'authorRole' => $authorRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_author_role_edit", methods={"GET","POST"})
     * @param Request $request
     * @param AuthorRole $authorRole
     * @return Response
     */
    public function edit(Request $request, AuthorRole $authorRole): Response
    {
        $form = $this->createForm(AdminAuthorRoleType::class, $authorRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre rôle a été modifié');
            return $this->redirectToRoute('admin_author_role_index');
        }

        return $this->render('admin/author_role/edit.html.twig', [
            'author_role' => $authorRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_author_role_delete", methods={"DELETE"})
     * @param Request $request
     * @param AuthorRole $authorRole
     * @return Response
     */
    public function delete(Request $request, AuthorRole $authorRole): Response
    {
        if ($this->isCsrfTokenValid('delete' . $authorRole->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($authorRole);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre rôle a été supprimé');
        }

        return $this->redirectToRoute('admin_author_role_index');
    }
}
