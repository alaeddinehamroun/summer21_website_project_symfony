<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/comments/{post}', name: 'post.comments')]
    public function commentsPost(Post $post): Response
    {

       $comments=$post->getComments();

       return $this->render('post/details.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'page_title' => 'comments'
        ]);
    }
    #[Route('/add', name: 'post.add')]
    public function addPost(EntityManagerInterface $manager, Request $request): Response
    {
        $post=new Post();
        $form=$this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            /**@var User $user */
            $user=$this->getUser();
            $post->setOwner($user);
            $manager->persist($post);
            $manager->flush();
            $this->addFlash('posted',"post published");
            return $this->redirectToRoute('home');
        }

        return $this->render('post/add.html.twig',
            [
                'form'=>$form->createView(),
                'user'=>$this->getUser(),
            ]
        );
    }

}
