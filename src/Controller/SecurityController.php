<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')] //login page
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')] //logout action
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/reset-password', name: 'app_reset_password')] //reset password action
    public function forgottenPassword(Request $request, UserRepository $userRepository, TokenGeneratorInterface $tokenGeneratorInterface, EntityManagerInterface $entityManagerInterface, SendMailService $mail): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            //looking for the user by his mail set in the form
            $user = $userRepository->findOneByEmail($form->get('email')->getData());
            //Generate resetToken linked with the identified user
            if ($user) {
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetToken($token);
                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();
                //Generate URL
                $url = $this->generateUrl('app_forgotten_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                //Mail data
                $context = compact('url', 'user');
                $mail->send('noreply@snowtricks.com', $user->getEmail(), 'Réinitialisation de votre mot de passe', 'password_reset', $context);
                $this->addFlash('success', 'Email de réinitialisation envoyé avec succès');
                return $this->redirectToRoute('app_login');
            }
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset_password_request.html.twig', ['requestPassForm' => $form->createView()]);
    }
    #[Route(path: '/forgotten-password/{token}', name: 'app_forgotten_password')] //enter a new password
    public function resetPassword(string $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneByResetToken($token);

        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() and $form->isValid()) {
                $user->setResetToken(''); //delete the linked token
                $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();
                $this->addFlash('success', 'Mot de passe réinitialisé');
                return $this->redirectToRoute('app_home_');
            }
            return $this->render('security/reset_password.html.twig', ['passForm' => $form->createView()]);
        }
        $this->addFlash('danger', 'Jeton de sécurité invalide');
        return $this->redirectToRoute('app_home_');
    }
}
