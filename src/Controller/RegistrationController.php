<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\LyceenType;
use App\Security\EmailVerifier;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response
    {
        $user = new User();
        $lyceen = new Lyceen();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_LYCEEN']);

            $entityManager->persist($user);
            $entityManager->flush();

            $lyceenFormData = $form->get('lyceen')->getData();

            $lyceen->setNom($lyceenFormData->getNom());
            $lyceen->setPrenom($lyceenFormData->getPrenom());
            $lyceen->setTel($lyceenFormData->getTel());
            $lyceen->setLycee($lyceenFormData->getLycee());
            $lyceen->setNiveau($lyceenFormData->getNiveau());
            $lyceen->setUser($user);

            $email = (new TemplatedEmail())
                ->from('esgi@tp-symfony.fr')
                ->to($user->getEmail())
                ->subject('Nouvelle inscription')
                ->htmlTemplate('registration/confirmation_email.html.twig');

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                dump($e->getMessage());
            }

            $this->addFlash('success', 'Your account has been created. Please check your email to verify your email address.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
