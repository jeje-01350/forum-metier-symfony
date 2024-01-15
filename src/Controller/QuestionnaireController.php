<?php

// src/Controller/QuestionnaireController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_questionnaire')]
    public function fillQuestionnaire(Request $request): Response
    {
        $questions = [
            ['text' => 'Quel est votre avis sur la qualité des ateliers ?', 'type' => 'ouvert'],
            ['text' => 'Avez-vous trouvé les informations utiles ?', 'type' => 'ferme'],
            ['text' => 'Quels sont les points forts de l\'événement ?', 'type' => 'ouvert'],
            ['text' => 'Recommanderiez-vous cet événement à vos amis ?', 'type' => 'ferme'],
            ['text' => 'Quelles suggestions avez-vous pour améliorer le forum ?', 'type' => 'ouvert'],
        ];

        $formBuilder = $this->createFormBuilder();

        foreach ($questions as $index => $question) {
            $fieldName = 'question_' . $index;

            if ($question['type'] === 'ouvert') {
                $formBuilder->add($fieldName, TextType::class, [
                    'label' => $question['text'],
                    'required' => true,
                ]);
            } elseif ($question['type'] === 'ferme') {
                $formBuilder->add($fieldName, ChoiceType::class, [
                    'label' => $question['text'],
                    'choices' => ['Oui' => true, 'Non' => false],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
                ]);
            }
        }

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            return $this->redirectToRoute('app_home');
        }

        return $this->render('questionnaire/fill_questionnaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
