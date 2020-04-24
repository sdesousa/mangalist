<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manga")
 */
class MangaController extends AbstractController
{
    /**
     * @Route("/", name="manga_index", methods={"GET"})
     * @param MangaRepository $mangaRepository
     * @return Response
     */
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('manga/index.html.twig', [
            'mangas' => $mangaRepository->findBy([], ['title' => 'ASC']),
        ]);
    }
}
