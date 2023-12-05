<?php

namespace App\Controller;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('home', name:'home')]

    public function home() : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $data['titulo'] = 'Home';
        return $this->render('home/index.html.twig', $data);
    }

    #[Route('perfil', name:'perfil')]

    public function perfil( UsuarioRepository $userRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $data['usuario'] = $userRepository->findAll();
        $data['titulo'] = 'Seu perfil';
        return $this->render('home/perfil.html.twig', $data);
    }
}
