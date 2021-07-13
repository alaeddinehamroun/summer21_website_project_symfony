<?php

namespace App\Controller;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home/{page<\d+>?1}/{number<\d+>?5}', name: 'home')]
    public function index($page, $number,PaginatorInterface $paginator): Response
    {
        $repository=$this->getDoctrine()->getRepository('App:Post');
        $data=$repository->findBy([],['date'=>'desc'],null,null);
        $posts=$paginator->paginate($data,$page,$number);
        return $this->render('home/index.html.twig', [
            'page_name' => "home",
            'posts' => $posts,
        ]);
    }
}