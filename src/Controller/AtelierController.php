<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Form\AtelierType;
use App\Repository\AtelierRepository;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Math;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/atelier')]
class AtelierController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_atelier_index', methods: ['GET'])]
    public function index(AtelierRepository $atelierRepository, ForumRepository $forumRepository): Response
    {
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $atelierRepository->findAll(),
            'forum' => $forumRepository->findClosestForum(),
        ]);
    }

    #[Route('/new', name: 'app_atelier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $atelier = new Atelier();
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('atelier/new.html.twig', [
            'atelier' => $atelier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_atelier_show', methods: ['GET'])]
    public function show(Atelier $atelier): Response
    {
        return $this->render('atelier/show.html.twig', [
            'atelier' => $atelier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_atelier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the associated Salle
            $salle = $atelier->getSalle();
            if ($salle !== null) {
                $entityManager->persist($salle);
            }

            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('atelier/edit.html.twig', [
            'atelier' => $atelier,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_atelier_delete', methods: ['POST'])]
    public function delete(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$atelier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($atelier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/api/inscrits-par-ateliers-creneaux', name: 'api_inscrits_par_ateliers_creneaux')]
    public function inscritsParAteliersCreneaux( AtelierRepository $atelierRepository): JsonResponse
    {
        $ateliers = $atelierRepository->findAll();

        $result = [];

        foreach ($ateliers as $atelier) {
            $atelierData = [
                'id' => $atelier->getId(),
                'nom' => $atelier->getName(),
                'heureDebut' => $atelier->getHeureDebut()->format('H:i'),
                'heureFin' => $atelier->getHeureFin()->format('H:i'),
                'intervenant' => $atelier->getIntervenant(),
                'secteur' => $atelier->getSecteur() !== null ? $atelier->getSecteur()->getNom() : null,
                'salle' => $atelier->getSalle() !== null ? $atelier->getSalle()->getNom() : null,
                'nombreInscrits' => rand(0, 30),
            ];

            $result[] = $atelierData;
        }

        return $result !== [] ? new JsonResponse($result) : new JsonResponse(['error' => 'No data'], Response::HTTP_NOT_FOUND);
    }
}
