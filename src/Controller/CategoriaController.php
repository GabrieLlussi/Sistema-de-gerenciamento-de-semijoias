<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Form\CategoriaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    #[Route('/categoria/index', name: 'app_categoria')]
        public function index(CategoriaRepository $catRepository) : Response
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $data['categoria'] = $catRepository->findAll();
            $data['titulo'] = 'Gerenciar categorias';
    
            return $this->render('categoria/index.html.twig', $data);
        }
        #[Route('/categoria/adicionar', name:'categoria/adicionar')]

        public function adicionar(Request $request, EntityManagerInterface $em) : Response
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $msg = '';
            $categorias = new Categoria();
            $form = $this->createForm(CategoriaType::class, $categorias);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                $em->persist($categorias);
                $em->flush();
                $msg='Categoria Adicionada com sucesso';
            }
    
            $data['titulo'] = 'Adicionar nova categoria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('categoria/form.html.twig', $data);
        }
    
        #[Route('/categoria/editar', name:'categoria/editar')]
    
        public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response
         {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $msg ='';
            $categoria = $categoriaRepository->find($id);
            $form = $this->createForm(CategoriaType::class, $categoria);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){
                $em->flush();
                $msg = 'Categoria atualizada com sucesso';
    
            }
            $data['titulo'] = 'Editar categoria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('categoria/form.html.twig', $data);
         }
    
         #[Route('/categoria/excluir', name:'categoria/excluir')]
    
         public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response
         {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $categoria = $categoriaRepository->find($id);
    
            $em->remove($categoria); 
            $em->flush(); 
    
            return $this->redirectToRoute('categoria');
         }
}
