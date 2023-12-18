<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_questionnaire')]
    public function fillQuestionnaire(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('question1', null, ['label' => 'Question 1'])
            ->add('question2', null, ['label' => 'Question 2'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_home'); // Remplacez 'app_home' par la route souhaitée
        }

        return $this->render('questionnaire/fill_questionnaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
