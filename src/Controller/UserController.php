<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ThumbnailType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\FollowersRepository;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/signup", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{username}", name="user_panel", methods={"GET","POST"})
     */
    public function showPanel(Request $request, SluggerInterface $slugger, User $user, PostRepository $postRepository, SubscriptionRepository $subscriptionRepository, FollowersRepository $followersRepository): Response
    {
        $thumbnailUser = new User();
        $form = $this->createForm(ThumbnailType::class, $thumbnailUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $thumbnailFile */
            $thumbnailFile = $form->get('thumbnail')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($thumbnailFile) {
                $originalFilename = pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnailFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $thumbnailFile->move(
                        $this->getParameter('thumbnails_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $thumbnailUser->setThumbnail($newFilename);

                $user->setThumbnail(
                    $newFilename,
                )
            ;

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        $id_user = $user->getId();

        return $this->render('user/panel.html.twig', [
            'user' => $user,
            'post' => $postRepository->findBy(['id_user' =>$id_user]),
            'subscription' => $subscriptionRepository->findBy(['id_user' =>$id_user]),
            'follower' => $followersRepository->findBy(['id_user' =>$id_user]),
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/remove/{thumbnail}", name="userThumbnail_delete", methods={"POST","GET"})
     */
    public function deleteUserThumbnail(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getThumbnail(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $nullThumb = null;
            $user->setThumbnail(
                $nullThumb,
            );
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
}
