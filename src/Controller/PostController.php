<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\FollowersRepository;
use App\Repository\LikeRepository;
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
     * @Route("/home/{username}", name="post", methods={"GET","POST"})
     */
    public function showUserPost(SubscriptionRepository $subscriptionRepository, FollowersRepository $followersRepository, User $user, Request $request, UserRepository $userRepository, PostRepository $postRepository, AuthenticationUtils $authenticationUtils, SubscriptionRepository $subscriptionRepo): Response
    {
        $currentUsername = $request->attributes->get('username');
        $currentUserId = $userRepository->findOneBy(['username' => $currentUsername]);
        $test = $subscriptionRepository->findBy(['user' => $currentUserId]);
        foreach ($test as $sub) {
            $idsub[] = $sub->getIdUser();
        }

        if ($this->getUser() && !empty($idsub)) {
            return $this->render('post/index.html.twig', [
                'posts' => $postRepository->findBy(['user' => $idsub]),
                'subscription' => $subscriptionRepository->findBy(['id_user' => $currentUserId]),
                'follower' => $followersRepository->findBy(['id_user' => $currentUserId]),
            ]);
        } else {
            return $this->render('post/index.html.twig', [
                'posts' => null,
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
     * Permet de liker ou unliker un article
     *
     * @Route("/post/{id}/like", name="post_like")
     * 
     * @param Post $post
     * @param ObjectManager $manager
     * @param LikeRepository $likeRepository
     * @return Response
     */
    public function like(Post $post, LikeRepository $likeRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => "Unauthorized"
            ], 403);
        }

        if ($post->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy([
                'id_post' => $post,
                'id_user' => $user
            ]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($like);
            $entityManager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimé',
                'likes' => $likeRepository->count(['id_post' => $post])
            ], 200);
        }

        $like = new Like();
        $like->setIdPost($post)
            ->setIdUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouté',
            'likes' => $likeRepository->count(['id_post' => $post])
        ], 200);
    }
}
