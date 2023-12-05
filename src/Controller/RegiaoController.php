<?php

namespace App\Controller;

use App\Entity\Regiao;
use App\Form\RegiaoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RegiaoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class RegiaoController extends AbstractController
{
    #[Route('regiao', name:'regiao/index')]

    public function index(RegiaoRepository $regiaoRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $data['regiao'] = $regiaoRepository->findAll();
        $data['titulo'] = 'Gerenciar regioes';

        return $this->render('regiao/index.html.twig', $data);
    }

    #[Route('regiao/adicionar', name:'regiao/adicionar')]

    public function adicionar(Request $request, EntityManagerInterface $em) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $msg = '';
        $regiao = new Regiao();
        $form = $this->createForm(RegiaoType::class, $regiao);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($regiao);
            $em->flush();
            $msg='Regiao adicionada com sucesso';
        }

        $data['titulo'] = 'Adicionar nova regiao';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('regiao/form.html.twig', $data);
    }

    #[Route('regiao/editar', name:'regiao/editar')]
    public function editar($id, Request $request, EntityManagerInterface $em, RegiaoRepository $regiaoRepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $msg ='';
        $regiao = $regiaoRepository->find($id);
        $form = $this->createForm(RegiaoType::class, $regiao);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $msg = 'Região atualizada com sucesso';

        }
        $data['titulo'] = 'Editar Região';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('regiao/form.html.twig', $data);
     }

     #[Route('regiao/excluir', name:'regiao/excluir')]

     public function excluir($id, EntityManagerInterface $em, RegiaoRepository $regiaoRepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $regiao = $regiaoRepository->find($id);

        $em->remove($regiao); 
        $em->flush(); 

        return $this->redirectToRoute('regiao');
     }
}
