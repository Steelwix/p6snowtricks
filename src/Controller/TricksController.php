<?php

namespace App\Controller;

use App\Entity\Illustration;
use App\Entity\Media;
use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentaryFormType;
use App\Form\CreateTrickFormType;
use App\Form\ModifyTrickFormType;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class TricksController extends AbstractController
{
    #[Route('/', name: 'app_home_')] //homepage
    public function homepage(TrickRepository $trickRepository): Response
    {
        return $this->render('tricks/homepage.html.twig', [
            'title' => 'Tous les tricks', 'tricks' => $trickRepository->findBy(
                [],
                ['trickName' => 'asc']
            )
        ]);
    }

    #[Route('trick/{slug}', name: 'app_trick')] //Trick page (any)
    public function show(
        Trick $trick,
        MessageRepository $messageRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        VideoRepository $vr
    ): Response {
        //get user and all datas of the trick
        $user = $this->getUser();
        $messages = $messageRepository->findBy(['idTrick' => $trick], ['date' => 'DESC']);
        $videos = $vr->findByIdTrick($trick);
        $creationDate = $trick->getCreationDate();
        $newDate = $creationDate->format('d-m-Y');
        $modificationDate = $trick->getModificationDate();
        if ($modificationDate != null) {
            $realDate = $creationDate->format('d-m-Y');
        } else {
            $realDate = null;
        }
        $trickGroup = $trick->getTrickGroup();
        $group = $trickGroup->getTrickGroupName();

        $form = $this->createForm(CommentaryFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            //If a new comment is posted
            $newMessage = new Message;
            $newMessage->setContent($form->get('comment')->getData());
            $newMessage->setIdTrick($trick);
            $newMessage->setDate(new DateTimeImmutable());
            $newMessage->setAuthor($user);
            $entityManager->persist($newMessage);
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire publié');
            $currentSlug = $request->get('slug');
            return $this->redirectToRoute('app_trick', ['slug' => $currentSlug]);
        }

        return $this->render(
            'tricks/tricks.html.twig',
            [
                'comForm' => $form->createView(),
                'trick' => $trick, 'messages' => $messages, 'videos' => $videos, 'creationDate' => $newDate, 'modificationDate' => $realDate, 'group' => $group

            ]


        );
    }

    #[Route('/create', name: 'app_create_trick')] //create a trick
    public function createTrick(TrickRepository $trickRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $trick = new Trick;
        $user = $this->getUser();
        $form = $this->createForm(CreateTrickFormType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            //add an image illustration
            $illustration = $form->get('illustration')->getData();
            if ($illustration !== null) {
                $illustrationName = md5(uniqid()) . '.' . $illustration->guessExtension();
                $illustration->move($this->getParameter('media_directory'), $illustrationName);
                //Any illustration image is also a media
                $newIllustration = new Media;
                $newIllustration->setMediaName($illustrationName);
                $trick->addMedium($newIllustration);
                $illustration = new Illustration;
                $illustration->setIdMedia($newIllustration);
                $trick->setIllustration($illustration);
            }
            //Get medias from form
            $medias = $form->get('media')->getData();
            if ($medias !== null) {
                foreach ($medias as $media) {
                    $mediaName = md5(uniqid()) . '.' . $media->guessExtension();
                    $media->move($this->getParameter('media_directory'), $mediaName);

                    $newMedia = new Media;
                    $newMedia->setMediaName($mediaName);
                    $trick->addMedium($newMedia);
                }
            }

            $trick->setAuthor($user);
            //check if the trick name is already used
            $trickName = $form->get('trick_name')->getData();
            $allTricks = $trickRepository->findAll();
            foreach ($allTricks as $allTrick) {
                $allTrickName = $allTrick->getTrickName();
                if ($trickName == $allTrickName) {
                    $this->addFlash('danger', 'Ce nom de Trick est déjà pris');

                    return $this->redirectToRoute('app_create_trick');
                }
            }
            //set slug using the Trick Name variable
            $trickNameNoSpace = $trickName ? new UnicodeString(str_replace(' ', '-', $trickName)) : null;
            $trickSlug = strtolower($trickNameNoSpace);
            $trick->setSlug($trickSlug);

            //add a link video
            $video = new Video;
            $link = $form->get('url')->getData();
            if ($link !== null) {
                //Youtube requires the 'embed/' part in the url to display the video on a website
                $link = (new UnicodeString($link))
                    ->replace('watch?v=', 'embed/');
                $video->setLink($link);
                $video->setIdTrick($trick);
                $trick->addVideo($video);
                $entityManager->persist($video);
            }
            $date = new \DateTime('@' . strtotime('now'));
            $trick->setCreationDate($date);
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Votre nouveau Trick a été publié');

            return $this->redirectToRoute('app_home_', ['_fragment' => 'toppage']);
        }

        return $this->render(
            'tricks/create_trick.html.twig',
            [
                'createTrickForm' => $form->createView(), 'trick' => $trick
            ]
        );
    }

    #[Route('trick/modify/{slug}', name: 'app_modify_trick')] //modify a trick
    public function modifyTrick(Trick $trick, VideoRepository $vr, Request $request, EntityManagerInterface $entityManager)
    {
        //get all videos
        $videos = $vr->findByIdTrick($trick);
        $form = $this->createForm(ModifyTrickFormType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            //Get medias from form
            $medias = $form->get('media')->getData();
            foreach ($medias as $media) {
                $mediaName = md5(uniqid()) . '.' . $media->guessExtension();
                $media->move($this->getParameter('media_directory'), $mediaName);

                $newMedia = new Media;
                $newMedia->setMediaName($mediaName);
                $trick->addMedium($newMedia);
            }
            //check if there is any illustration image
            if ($trick->getIllustration() == null) {
                $illustration = $form->get('illustration')->getData();
                //if there is no illustration, it accepts the new one
                $illustrationName = md5(uniqid()) . '.' . $illustration->guessExtension();
                $illustration->move($this->getParameter('media_directory'), $illustrationName);

                $newIllustration = new Media;
                $newIllustration->setMediaName($illustrationName);
                $trick->addMedium($newIllustration);
                $illustration = new Illustration;
                $illustration->setIdMedia($newIllustration);
                $trick->setIllustration($illustration);
            }
            //add a new video
            $video = new Video;
            $link = $form->get('url')->getData();
            if ($link !== null) {
                //Youtube requires the 'embed/' part in the url to display the video on a website
                $link = (new UnicodeString($link))
                    ->replace('watch?v=', 'embed/');
                $video->setLink($link);
                $video->setIdTrick($trick);
                $trick->addVideo($video);
                $entityManager->persist($video);
            }
            //Get the user to be the new author
            $user  = $this->getUser();
            $trick->setAuthor($user);
            //get trick name to use it as a slug with no space and lower case text
            $trickName = $form->get('trick_name')->getData();
            $trickNameNoSpace = $trickName ? new UnicodeString(str_replace(' ', '-', $trickName)) : null;
            $trickSlug = strtolower($trickNameNoSpace);
            $trick->setSlug($trickSlug);
            //Set the modification date
            $date = new \DateTime('@' . strtotime('now'));
            $trick->setModificationDate($date);
            $trick->setTrickGroup($form->get('trickGroup')->getData());
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick modifié');
            return $this->redirectToRoute('app_trick', ['slug' => $trickSlug]);
        }
        return $this->render(
            'tricks/modify_trick.html.twig',
            [
                'ModifyTrickForm' => $form->createView(), 'trick' => $trick, 'videos' => $videos
            ]
        );
    }

    #[Route('trick/remove/{id}', name: 'app_remove_trick')] //delete a trick
    public function deletetrick(Request $request, Trick $trick, EntityManagerInterface $em)
    {
        $trickId = $trick->getId();
        $medias = $trick->getMedia();
        //set the redirection after the delete
        $url = $this->generateUrl('app_home_');
        //get the json data from the delete button
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $trickId, $data['_token'])) {
            //delete all medias from the trick
            foreach ($medias as $media) {
                $mediaName = $media->getMediaName();
                unlink($this->getParameter('media_directory') . '/' . $mediaName);
                $em->remove($media);
            }
            //delete all videos from the trick
            $videos = $trick->getVideos();
            foreach ($videos as $video) {
                $em->remove($video);
            }
            //delete the trick
            $em->remove($trick);
            $em->flush();
            return new JsonResponse([
                'success' => 1,
                'redirect' => $url
            ]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
    #[Route('media/remove/media/{id}', name: 'app_remove_media', methods: "DELETE")] //delete a media
    public function deleteMedia(Request $request, Media $media, EntityManagerInterface $em)
    {
        //get the json data from the delete button
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $media->getId(), $data['_token'])) {
            $mediaName = $media->getMediaName();
            unlink($this->getParameter('media_directory') . '/' . $mediaName);
            $em->remove($media);
            $em->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
    #[Route('media/remove/video/{id}', name: 'app_remove_video', methods: "DELETE")] //delete a video
    public function deleteVideo(Request $request, Video $video, EntityManagerInterface $em)
    {
        //get the json data from the delete button
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $video->getId(), $data['_token'])) {
            $em->remove($video);
            $em->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}
