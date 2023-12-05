<?php

namespace App\Controller;

use App\Entity\Carrinho;
use App\Form\UserEditType;
use App\Form\AdmEditType;
use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Repository\UsuarioRepository;
use App\Service\CpfValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('register/index', name:'register/index')]

    public function index(UsuarioRepository $userRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $data['usuario'] = $userRepository->findAll();
        $data['titulo'] = 'Usuários';

        return $this->render('registration/index.html.twig', $data);
    }

    #[Route('register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, CpfValidator $cpfValidator,  EntityManagerInterface $entityManager): Response
    {
        $msg ='';
        $user = new Usuario();
        $carrinho = new Carrinho();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEstadoAtual('Ativo');
            $user->setRoles(['ROLE_USER']);

            $cpf = $user->getCpf();
            $telefone = $user->getTelefone();
            if ($cpfValidator->isValid($cpf)) {
                $entityManager->persist($user);
                $entityManager->flush();
                $carrinho->setIdUsuario($user);
                $carrinho->setStatus('pendente');
                $entityManager->persist($carrinho);
                $msg = 'Usuário adicionado';
                $entityManager->flush();
            // do anything else you need here, like send an email
            } else {
            $msg = 'Algo está incorreto';
            }
        }
    
        $data['titulo'] = 'Cadastro de usuários';
        $data['subTitulo'] = 'Insira seus dados';
        $data['button'] = 'Criar conta';
        $data['form'] = $form;
        $data['msg'] = $msg;
    
        return $this->render('registration/register.html.twig', $data);
    
    }

    #[Route('register/editar', name:'register/editar')]
    public function editar($id, Request $request, EntityManagerInterface $em, UsuarioRepository $userRepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $msg ='';
        $usuario = $userRepository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $usuario);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $msg = 'Usuário atualizado com sucesso';

        }
        $data['titulo'] = 'Editar Usuário';        
        $data['subTitulo'] = 'Insira seus dados';
        $data['button'] = 'Finalizar edição';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('registration/register.html.twig', $data);
     }

     #[Route('register/excluir', name:'register/excluir')]

     public function excluir($id, EntityManagerInterface $em, UsuarioRepository $userRepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $usuario = $userRepository->find($id);

        $em->remove($usuario); 
        $em->flush(); 

        return $this->redirectToRoute('register/index');
     }

     public function estado($id, EntityManagerInterface $em, UsuarioRepository $userRepository): Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $usuario = $userRepository->find($id);

        $novoEstado = ($usuario->getEstadoAtual() === 'Ativo') ? 'Inativo' : 'Ativo';
        $usuario->setEstadoAtual($novoEstado);

        $em->persist($usuario);
        $em->flush();

        return $this->redirectToRoute('register/index');
     }

     #[Route('register/editUser', name:'register/editUser')]

    public function editUser($id, Request $request, EntityManagerInterface $em, UsuarioRepository $userRepository): Response
     {
        $usuario = $userRepository->find($id);

        $msg = '';
        $form = $this->createForm(UserEditType::class, $usuario);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $msg = 'Dados alterados com sucesso com sucesso';
            return $this->redirectToRoute('perfil');
        }
        $data['titulo'] = 'Editar Usuário';        
        $data['subTitulo'] = 'Insira seus dados';
        $data['button'] = 'Finalizar edição';
        $data['form'] = $form;
        $data['msg'] = $msg;
        return $this->render('home/editUser.html.twig', $data);
    }

    public function editAdmin($id, Request $request, EntityManagerInterface $em, UsuarioRepository $userRepository): Response
     {
        $usuario = $userRepository->find($id);

        $msg = '';
        $form = $this->createForm(AdmEditType::class, $usuario);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('register/index');
        }
        $data['titulo'] = 'Editar usuário';        
        $data['subTitulo'] = 'Insira seus dados';
        $data['button'] = 'Finalizar edição';
        $data['form'] = $form;
        $data['msg'] = $msg;
        return $this->render('home/editUser.html.twig', $data);
    }

}