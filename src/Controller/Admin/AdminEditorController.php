<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\Admin\AdminEditorType;
use App\Repository\EditorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/editor")
 */
class AdminEditorController extends AbstractController
{
    /**
     * @Route("/", name="admin_editor_index", methods={"GET"})
     * @param EditorRepository $editorRepository
     * @return Response
     */
    public function index(EditorRepository $editorRepository): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'editors' => $editorRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_editor_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $editor = new Editor();
        $form = $this->createForm(AdminEditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editor);
            $entityManager->flush();
            $this->addFlash('success', 'Votre éditeur a été créé');
            return $this->redirectToRoute('admin_editor_index');
        }

        return $this->render('admin/editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_editor_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Editor $editor
     * @return Response
     */
    public function edit(Request $request, Editor $editor): Response
    {
        $form = $this->createForm(AdminEditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre éditeur a été modifié');
            return $this->redirectToRoute('admin_editor_index');
        }

        return $this->render('admin/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_editor_delete", methods={"DELETE"})
     * @param Request $request
     * @param Editor $editor
     * @return Response
     */
    public function delete(Request $request, Editor $editor): Response
    {
        if ($this->isCsrfTokenValid('delete' . $editor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editor);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre rôle a été supprimé');
        }

        return $this->redirectToRoute('admin_editor_index');
    }
}
