<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends AbstractController
{
    public function forgotPassword(Request $request, \Swift_Mailer $mailer): Response
    {
        // Lógica para processar a solicitação de recuperação de senha
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            // Aqui você pode adicionar a lógica para gerar um token único
            // e associá-lo ao usuário no banco de dados.

            // Em seguida, você enviaria um e-mail ao usuário com um link contendo esse token.
            $message = (new \Swift_Message('Recuperação de Senha'))
                ->setFrom('noreply@example.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/forgot_password.html.twig',
                    ),
                    'text/html'
                );

            $mailer->send($message);

            // Exibir uma mensagem de sucesso
            $this->addFlash('success', 'Um e-mail de recuperação foi enviado.');

            return $this->redirectToRoute('app_login'); // Redirecionar para a página de login
        }

        return $this->render('security/forgot_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}