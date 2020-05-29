<?php

namespace App\Controller\Admin;

use App\Entity\EditorCollection;
use App\Form\Admin\AdminEditorCollectionType;
use App\Repository\EditorCollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/collection")
 */
class AdminEditorCollectionController extends AbstractController
{
    /**
     * @Route("/", name="admin_collection_index", methods={"GET"})
     * @param EditorCollectionRepository $collectionRepository
     * @return Response
     */
    public function index(EditorCollectionRepository $collectionRepository): Response
    {
        return $this->render('admin/editor_collection/index.html.twig', [
            'editorCollections' => $collectionRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_collection_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $editorCollection = new EditorCollection();
        $form = $this->createForm(AdminEditorCollectionType::class, $editorCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editorCollection);
            $entityManager->flush();
            $this->addFlash('success', 'Votre collection a été créée');
            return $this->redirectToRoute('admin_collection_index');
        }

        return $this->render('admin/editor_collection/new.html.twig', [
            'editorCollection' => $editorCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_collection_edit", methods={"GET","POST"})
     * @param Request $request
     * @param EditorCollection $editorCollection
     * @return Response
     */
    public function edit(Request $request, EditorCollection $editorCollection): Response
    {
        $form = $this->createForm(AdminEditorCollectionType::class, $editorCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre collection a été modifiée');
            return $this->redirectToRoute('admin_collection_index');
        }

        return $this->render('admin/editor_collection/edit.html.twig', [
            'editorCollection' => $editorCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_collection_delete", methods={"DELETE"})
     * @param Request $request
     * @param EditorCollection $editorCollection
     * @return Response
     */
    public function delete(Request $request, EditorCollection $editorCollection): Response
    {
        if ($this->isCsrfTokenValid('delete' . $editorCollection->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editorCollection);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre collection a été supprimée');
        }

        return $this->redirectToRoute('admin_collection_index');
    }
}
