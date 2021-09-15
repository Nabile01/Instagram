<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\FollowersRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use PhpParser\Node\Expr\Cast\Object_;
use Doctrine\Persistence\ObjectManager;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{username}", name="post", methods={"GET","POST"})
     */
    public function showUserPost(SubscriptionRepository $subscriptionRepository, FollowersRepository $followersRepository, User $user,Request $request, UserRepository $userRepository, PostRepository $postRepository, AuthenticationUtils $authenticationUtils, SubscriptionRepository $subscriptionRepo): Response
    {
        $currentUsername = $request->attributes->get('username');
        $currentUserId= $userRepository->findOneBy(['username'=> $currentUsername]);
        $test = $subscriptionRepository->findBy(['user' => $currentUserId]);
        foreach($test as $sub) {
            $idsub[] = $sub->getIdUser();
        }

        if ($this->getUser()) {
            return $this->render('post/index.html.twig', [
                'posts' => $postRepository->findBy(['user'=>$idsub]),
                'subscription' => $subscriptionRepository->findBy(['id_user' =>$currentUserId]),
                'follower' => $followersRepository->findBy(['id_user' =>$currentUserId]),
            ]);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['lastUsername' => $lastUsername, 'error' => $error]);
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
    public function isLikedByUser(User $user): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
