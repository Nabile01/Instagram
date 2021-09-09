<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function showUserPost(): Response
    {
        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/test", name="all_post", methods={"GET","POST"})
     */
    public function index(PostRepository $postRepository, User $user): Response
    {
        return $this->render('user/panel.html.twig', [
            'posts' => $postRepository->findAll(),
            'controller_name' => 'PostController',
            'users' => $user->getPost(),
        ]);
    }
}
