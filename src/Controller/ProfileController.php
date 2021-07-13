<?php

namespace App\Controller;

use App\Form\MediaType;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(EntityManagerInterface $manager,Request $request): Response
    {
        $user=$this->getUser();
        return $this->render('profile/profile.html.twig', [
            'user'=>$user,
        ]);
    }
    #[Route('/profile/edit', name: 'profile.edit')]
    public function profileEdit(EntityManagerInterface $manager,Request $request): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',"profile infos edited");
            return $this->redirectToRoute('profile');
        }
        return $this->render('profile/edit_profile.html.twig', [
            'editProfile'=>$form->createView(),

        ]);
    }



    #[Route('profile/addImage', name: 'profile.add_image')]
    public function addImage(EntityManagerInterface $manager,Request $request): Response
    {
        $repository=$this->getDoctrine()->getRepository('App:Media');
        $media=$repository->findOneBy(['user' => $this->getUser()]);
        if($media->getImage()==null){
            $form = $this->createForm(MediaType::class,$media);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $manager->persist($media);
                $manager->flush();
                $this->addFlash('success',"image uploaded");
                return $this->redirectToRoute('profile');
            }
            return $this->render('profile/addImage.html.twig', [
                'addImage'=>$form->createView(),
            ]);
        }
        else{
            $this->addFlash('already',"image already added! if you wish to change it click on edit profile");
            return $this->redirectToRoute('profile');
        }
    }
}
