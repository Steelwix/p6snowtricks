<?php

namespace App\Controller;

use App\Entity\ProfilePicture;
use App\Form\AccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')] //Profile view
    public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            //add profile picture if there is none
            $profilePicture = $form->get('profilePicture')->getData();
            if ($user->getProfilePicture() == null) {

                $ppName = md5(uniqid()) . '.' . $profilePicture->guessExtension();
                //Set image in server folders
                $profilePicture->move(
                    $this->getParameter('profile_picture_directory'),
                    $ppName
                );
                //Set image name in the database
                $pp = new ProfilePicture;
                $pp->setName($ppName);
                $pp->setUser($user);
                $entityManager->persist($pp);
                $entityManager->flush();
                return $this->redirectToRoute('app_profile');
            }
        }
        return $this->render('profile/profile.html.twig', [
            'accountForm' => $form->createView(),
        ]);
    }
    #[Route('/profile/removepp', name: 'app_remove_pp')] //delete the profile picture
    public function deletePp(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $pp = $user->getProfilePicture();
        $ppName = $pp->getName();
        unlink($this->getParameter('profile_picture_directory') . '/' . $ppName);
        $em->remove($pp);
        $em->flush();
        $this->addFlash('success', 'photo supprimée');
        return $this->redirectToRoute('app_profile');
    }
}
