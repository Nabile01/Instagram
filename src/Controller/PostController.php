<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function showUserPost(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/test", name="all_post", methods={"GET","POST"})
     */
    public function index(PostRepository $postRepository, User $user): Response
    {
        return $this->render('user/panel.html.twig', [
            'posts' => $postRepository->findAll(),
            'users' => $user->getPost(),
        ]);
    }

    /**
     * Permet de savoir si cet article est liké par un user
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user): bool {
        foreach($this->likes as $like) {
            if($like->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
