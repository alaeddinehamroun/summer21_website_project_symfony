<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('addComment/{post}', name: 'comment.add')]
    public function addComment(EntityManagerInterface $manager, Request $request, Post $post): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**@var User $user */
            $user = $this->getUser();
            $comment->setUser($user);
            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('commented', "comment added");
            return $this->redirectToRoute('post.comments',['post'=>$post->getId()]);
        }
        return $this->render('comment/addComment.html.twig',
            [
                'form' => $form->createView(),
                'user' => $this->getUser(),
            ]
        );
    }
}
