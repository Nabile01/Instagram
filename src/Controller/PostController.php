<?php

namespace App\Controller;

use App\Repository\PostRepository;
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
     * @Route("/test", name="user_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $postRepository->findAll(),
        ]);
    }
}
