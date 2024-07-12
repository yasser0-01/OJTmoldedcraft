<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        $data = $this->getDoctrine()->getRepository(Crud::class)->findAll();
        return $this->render('home/index.html.twig', [
            // 'controller_name' => 'HomeController',
            'list' => $data
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request)
    {
        $crud = new Crud();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice', 'Submitted Successfully!!');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/update{id}', name: 'update')]
    public function update(Request $request, $id){
        $crud = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice', 'Updated Successfully!!');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete{id}', name: 'delete')]
    public function delete($id){
        $data = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice', 'Deleted Successfully!');

        return $this->redirectToRoute('home');
    }
}
