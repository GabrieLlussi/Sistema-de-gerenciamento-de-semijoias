<?php

namespace App\Controller;

use App\Entity\Carrinho;
use App\Entity\CarrinhoProduto;
use App\Entity\LogVendas;
use App\Entity\LogVendasItem;
use App\Repository\CarrinhoProdutoRepository;
use App\Repository\CarrinhoRepository;
use App\Repository\LogVendasItemRepository;
use App\Repository\LogVendasRepository;
use App\Repository\ProdutoRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarrinhoController extends AbstractController
{
    #[Route('/carrinho', name: 'app_carrinho')]
    public function index(EntityManagerInterface $em, CarrinhoRepository $carrinhoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository, LogVendasRepository $logVendasRepository, LogVendasItemRepository $logVendasItemRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $usuario = $this->getUser();

        $carrinho = $carrinhoRepository->findOneBy(['id_usuario' => $usuario]);
        $logVendas = $logVendasRepository->findOneBy(
            ['idCarrinho' => $carrinho],
            ['numeroCarrinho' => 'DESC']
        );
        $logVendasItems = $logVendasItemRepository->findBy(['logVenda' => $logVendas]);

        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->setIdUsuario($usuario);
            $carrinho->setStatus('pendente');

            $em->persist($carrinho);
            $em->flush();
        }

        $data['carrinho'] = $carrinho;
        $data['logVendas'] = $logVendas;
        $data['logVendasItems'] = $logVendasItems;

        $data['carrinhoProduto'] = $carrinhoProdutoRepository->findBy(['id_carrinho' => $carrinho]);

        return $this->render('carrinho/index.html.twig', $data);
    }

    #[Route('/verificar_carrinho', name: 'app_carrinho')]

    public function verificar($id, UsuarioRepository $userRepository, CarrinhoRepository $carrinhoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository, LogVendasRepository $logVendasRepository, LogVendasItemRepository $logVendasItemRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $usuario = $userRepository->find($id);
        $carrinho = $carrinhoRepository->findOneBy(['id_usuario' => $usuario]);
        $logVendas = $logVendasRepository->findOneBy(
            ['idCarrinho' => $carrinho],
            ['numeroCarrinho' => 'DESC']
        );
        $logVendasItems = $logVendasItemRepository->findBy(['logVenda' => $logVendas]);

        $data['carrinho'] = $carrinho;   
        $data['usuario'] = $usuario;     
        $data['carrinhoProduto'] = $carrinhoProdutoRepository->findBy(['id_carrinho' => $carrinho]);
        $data['logVendasItems'] = $logVendasItems;

        return $this->renderForm('carrinho/index.html.twig', $data);
    }

     #[Route('/adicionar_carrinho', name: 'app_carrinho')]

     public function adicionar($idProduto, $quantidade, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $produto = $produtoRepository->find($idProduto);
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        $carrinhoProduto = $carrinhoProdutoRepository->findOneBy(['id_produto' => $produto, 'id_carrinho' => $carrinho]);

        $quantidade = $request->request->get('quantidade'.$idProduto, 1);

        if (!$produto || $quantidade <= 0 || $quantidade > $produto->getQuantidade()) {
            return $this->redirect($request->headers->get('referer'));
        }

        // Calcula a soma total da quantidade dos produtos no carrinho
        $somaQuantidadesCarrinho = 0;
        foreach ($carrinho->getCarrinhoProdutos() as $carrinhoProdutoExistente) {
            $somaQuantidadesCarrinho += $carrinhoProdutoExistente->getQuantidade();
        }

        // Verifica se a soma total ultrapassa o limite do usuário
        if ($somaQuantidadesCarrinho + $quantidade > $usuario->getLimite()) {
            // Implemente a lógica adequada para lidar com a ultrapassagem do limite.
            return $this->redirect($request->headers->get('referer'));
        }

        if ($carrinhoProduto) {
            // Atualiza a quantidade disponível do produto no banco de dados
            $novaQuantidadeProduto = $produto->getQuantidade() - $quantidade;
            $produto->setQuantidade($novaQuantidadeProduto);

            // Atualiza a quantidade do CarrinhoProduto
            $novaQuantidadeCarrinhoProduto = $carrinhoProduto->getQuantidade() + $quantidade;
            $carrinhoProduto->setQuantidade($novaQuantidadeCarrinhoProduto);
        } else {
            // Cria um novo CarrinhoProduto se não existir no carrinho
            $carrinhoProduto = new CarrinhoProduto();
            $carrinhoProduto->setIdProduto($produto);
            $carrinhoProduto->setIdCarrinho($carrinho);
            $carrinhoProduto->setQuantidade($quantidade);

            // Atualiza a quantidade disponível do produto no banco de dados
            $novaQuantidadeProduto = $produto->getQuantidade() - $quantidade;
            $produto->setQuantidade($novaQuantidadeProduto);
            $carrinhoProduto->setVendas(0);

            // Persiste o novo CarrinhoProduto no banco de dados
            $em->persist($carrinhoProduto);
        }

        // Persiste as alterações no banco de dados
        $em->persist($produto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/remover_carrinho', name: 'app_carrinho')]

    public function remover($idProduto, $quantidade, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository): Response
    {
        $produto = $produtoRepository->find($idProduto);
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        if (!$carrinho) {
            // Implemente a lógica adequada para lidar com a ausência de um carrinho.
            return $this->redirect($request->headers->get('referer'));
        }

        // Verifica se já existe um CarrinhoProduto para o mesmo produto no carrinho
        $carrinhoProduto = $carrinhoProdutoRepository->findOneBy(['id_produto' => $produto, 'id_carrinho' => $carrinho]);

        $quantidade = $request->request->get('quantidade'.$idProduto, 1);

        if (!$produto || $quantidade <= 0 || !$carrinhoProduto || $quantidade > $carrinhoProduto->getQuantidade()) {
            // Implemente a lógica adequada para lidar com situações inválidas.
            return $this->redirect($request->headers->get('referer'));
        }

        // Atualiza a quantidade disponível do produto no banco de dados
        $novaQuantidadeProduto = $produto->getQuantidade() + $quantidade;
        $produto->setQuantidade($novaQuantidadeProduto);

        // Atualiza a quantidade do CarrinhoProduto
        $novaQuantidadeCarrinhoProduto = $carrinhoProduto->getQuantidade() - $quantidade;
        $carrinhoProduto->setQuantidade($novaQuantidadeCarrinhoProduto);

        // Persiste as alterações no banco de dados
        $em->persist($produto);
        $em->persist($carrinhoProduto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/remover_carrinho_adm', name: 'app_carrinho')]

    public function removerAdm(CarrinhoRepository $carrinhoRepository, $idCarrinho, $idProduto, $quantidade, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $produto = $produtoRepository->find($idProduto);
        $carrinho = $carrinhoRepository->find($idCarrinho);

        if (!$carrinho) {
            // Implemente a lógica adequada para lidar com a ausência de um carrinho.
            return $this->redirect($request->headers->get('referer'));
        }

        // Verifica se já existe um CarrinhoProduto para o mesmo produto no carrinho
        $carrinhoProduto = $carrinhoProdutoRepository->findOneBy(['id_produto' => $produto, 'id_carrinho' => $carrinho]);

        $quantidade = $request->request->get('quantidade'.$idProduto, 1);

        if (!$produto || $quantidade <= 0 || !$carrinhoProduto || $quantidade > $carrinhoProduto->getQuantidade()) {
            // Implemente a lógica adequada para lidar com situações inválidas.
            return $this->redirect($request->headers->get('referer'));
        }

        // Atualiza a quantidade disponível do produto no banco de dados
        $novaQuantidadeProduto = $produto->getQuantidade() + $quantidade;
        $produto->setQuantidade($novaQuantidadeProduto);

        // Atualiza a quantidade do CarrinhoProduto
        $novaQuantidadeCarrinhoProduto = $carrinhoProduto->getQuantidade() - $quantidade;
        $carrinhoProduto->setQuantidade($novaQuantidadeCarrinhoProduto);

        // Persiste as alterações no banco de dados
        $em->persist($produto);
        $em->persist($carrinhoProduto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/removertodos_carrinho', name: 'app_carrinho')]

    public function removerTodos(Request $request, EntityManagerInterface $em, CarrinhoProdutoRepository $carrinhoProdutoRepository): Response
    {
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        if (!$carrinho) {
            // Implemente a lógica adequada para lidar com a ausência de um carrinho.
            return $this->redirect($request->headers->get('referer'));
        }

        // Obtém todos os CarrinhoProduto associados ao carrinho
        $carrinhoProdutos = $carrinhoProdutoRepository->findBy(['id_carrinho' => $carrinho]);

        foreach ($carrinhoProdutos as $carrinhoProduto) {
            $produto = $carrinhoProduto->getIdProduto();
            $quantidade = $carrinhoProduto->getQuantidade();

            // Atualiza a quantidade disponível do produto no banco de dados
            $novaQuantidadeProduto = $produto->getQuantidade() + $quantidade;
            $produto->setQuantidade($novaQuantidadeProduto);

            // Zera a quantidade do CarrinhoProduto
            $carrinhoProduto->setQuantidade(0);

            // Persiste as alterações no banco de dados
            $em->persist($produto);
            $em->persist($carrinhoProduto);
        }

        // Flush para persistir todas as alterações de uma vez
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/definir_status', name: 'app_carrinho')]
    
    public function definirStatus(Request $request, EntityManagerInterface $em, CarrinhoProdutoRepository $carrinhoProdutoRepository, LogVendasRepository $logVendasRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        if (!$carrinho) {
            // Implemente a lógica adequada para lidar com a ausência de um carrinho.
            return $this->redirect($request->headers->get('referer'));
        }

        $status = $request->request->get('status');

        switch ($status) {
            case 0:
                $statusText = 'pendente';
                break;
            case 1:
                $statusText = 'enviar';
                break;
            case 2:
                $statusText = 'retornar';
                $this->retornar($carrinhoProdutoRepository, $logVendasRepository, $em, $request);
                break;
            case 3:
                $statusText = 'confirmar';
                break;
            default:
                $statusText = 'pendente';
        }

        $status = $statusText;

        $carrinho->setStatus($status);


        $em->persist($carrinho);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));

    }

    #[Route('/definir_status_adm', name: 'app_carrinho')]
    
    public function definirStatusAdm($id, Request $request, EntityManagerInterface $em, UsuarioRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $usuario = $userRepository->find($id);
        $carrinho = $usuario->getCarrinho();

        if (!$carrinho) {
            // Implemente a lógica adequada para lidar com a ausência de um carrinho.
            return $this->redirect($request->headers->get('referer'));
        }

        $status = $request->request->get('status');

        switch ($status) {
            case 0:
                $statusText = 'pendente';
                break;
            case 1:
                $statusText = 'enviar';
                break;
            case 2:
                $statusText = 'retornar';
                break;
            case 3:
                $statusText = 'confirmar';
                break;
            default:
                $statusText = 'pendente';
        }

        $status = $statusText;

        $carrinho->setStatus($status);

        $em->persist($carrinho);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }

    public function vender($id, $quantidade, ProdutoRepository $produtoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $produto = $produtoRepository->find($id);
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        $carrinhoProduto = $carrinhoProdutoRepository->findOneBy(['id_produto' => $produto, 'id_carrinho' => $carrinho]);

        $quantidade = $request->request->get('quantidade'.$id, 1);

        if (!$produto || $quantidade <= 0 || $quantidade > $carrinhoProduto->getQuantidade()) {
            return $this->redirect($request->headers->get('referer'));
        }

        $carrinhoProduto->setQuantidade($carrinhoProduto->getQuantidade() - $quantidade);
        $carrinhoProduto->setVendas($carrinhoProduto->getVendas() + $quantidade);


        $em->persist($carrinhoProduto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    public function devolver($id, ProdutoRepository $produtoRepository, CarrinhoProdutoRepository $carrinhoProdutoRepository, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $produto = $produtoRepository->find($id);
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();

        $carrinhoProduto = $carrinhoProdutoRepository->findOneBy(['id_produto' => $produto, 'id_carrinho' => $carrinho]);

        $quantidade = $request->request->get('quantidade'.$id, 1);

        if (!$produto || $quantidade <= 0 || $quantidade > $carrinhoProduto->getVendas()) {
            return $this->redirect($request->headers->get('referer'));
        }

        $carrinhoProduto->setQuantidade($carrinhoProduto->getQuantidade() + $quantidade);
        $carrinhoProduto->setVendas($carrinhoProduto->getVendas() - $quantidade);


        $em->persist($carrinhoProduto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    public function retornar(CarrinhoProdutoRepository $carrinhoProdutoRepository, LogVendasRepository $logVendasRepository, EntityManagerInterface $em, Request $request) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $usuario = $this->getUser();
        $carrinho = $usuario->getCarrinho();
        $carrinhoProdutos = $carrinhoProdutoRepository->findBy(['id_carrinho' => $carrinho]);
        $carrinhoProdutos = array_filter($carrinhoProdutos, function ($carrinhoProduto) {
            return ($carrinhoProduto->getQuantidade() + $carrinhoProduto->getVendas()) >= 1;
        });
        $antigoLogVendas = $logVendasRepository->findOneBy(
            ['idCarrinho' => $carrinho],
            ['numeroCarrinho' => 'DESC']
        );

        if(!$antigoLogVendas)
        {
            $logVendas = new LogVendas();
            $logVendas->setIdCarrinho($carrinho);
            $logVendas->setNumeroCarrinho(1);
            $logVendas->setData(new \DateTime());

            $em->persist($logVendas);
            $em->flush();
        } else {
            $logVendas = new LogVendas();
            $logVendas->setIdCarrinho($carrinho);
            $logVendas->setNumeroCarrinho($antigoLogVendas->getNumeroCarrinho() + 1);
            $logVendas->setData(new \DateTime());

            $em->persist($logVendas);
            $em->flush();
        }

        foreach ($carrinhoProdutos as $carrinhoProduto) {
            $produto = $carrinhoProduto->getIdProduto();
            $quantidade = $carrinhoProduto->getQuantidade();
            $vendas = $carrinhoProduto->getVendas();
            $valor = $produto->getValor();

            $logVendasItem = new LogVendasItem();

            $logVendasItem->setLogVenda($logVendas);
            $logVendasItem->setIdProduto($produto);
            $logVendasItem->setQuantidade($vendas);
            $logVendasItem->setValor($valor);

            $novaQuantidadeProduto = $produto->getQuantidade() + $quantidade;
            $produto->setQuantidade($novaQuantidadeProduto);

            $carrinhoProduto->setQuantidade(0);
            $carrinhoProduto->setVendas(0);

            $em->persist($produto);
            $em->persist($logVendasItem);
            $em->remove($carrinhoProduto);
        }

        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}
