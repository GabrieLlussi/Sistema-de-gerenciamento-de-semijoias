<?php 

namespace App\Controller;

use App\Entity\LogProduto;
use App\Entity\Produto;
use App\Form\ProdutoFilterType;
use App\Repository\ProdutoRepository;
use App\Form\ProdutoType;
use App\Repository\CategoriaRepository;
use App\Repository\LogProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProdutoController extends AbstractController
{
    #[Route('produto', name:'joias/index')]

    public function index(Request $request, CategoriaRepository $categoriaRepository, ProdutoRepository $produtoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
       
        
        $data['produto'] = $produtoRepository->findAll();
        #$data['form'] = $form->createView();
        $data['titulo'] = 'Gerenciar estoque';

        return $this->render('produto/index.html.twig', $data);
    }

    #[Route('registroProdutos', name:'joias/index')]

    public function registroProdutos(LogProdutoRepository $logProdutoRepository): Response
    {
        // Recupere os logs de produtos do banco de dados
        $logProdutos = $logProdutoRepository->findBy([], ['data' => 'DESC']);

        return $this->render('registro/produto.html.twig', [
            'logProdutos' => $logProdutos,
        ]);
    }
    
    #[Route('produto/adicionar', name:'joiasAdicionar')]
   
    public function adicionar(Request $request, EntityManagerInterface $em) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $msg = '';
        $produto = new Produto();
        $logProduto = new LogProduto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        

        if($form->isSubmitted() && $form->isValid()){
            
            $imagem = $form->get('img')->getData();
            $imagemData = base64_encode(file_get_contents($imagem->getPathname()));
            $produto->setimg($imagemData);

            $produto->setStatus('Ativo');
            $produto->setQuantidade(0);

            $logProduto->setAcao('Adicionar');
            $logProduto->setProduto($produto);
            $logProduto->setNomeProduto($produto->getNome());
            $logProduto->setCategoria($produto->getCategoria());
            $logProduto->setValorProduto($produto->getValor());
            $logProduto->setQuantidadeProduto($produto->getQuantidade());
            $logProduto->setData(new \DateTime());
            $logProduto->setStatus($produto->getStatus());
            $em->persist($logProduto);

            $em->persist($produto);
            $em->flush();
            $msg='Produto adicionado com sucesso';
        }

        $data['titulo'] = 'Adicionar novo produto';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/form.html.twig', $data);
    }

    #[Route('produto/editar', name:'joias/editar')]
    public function editar($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtorepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $msg ='';
        $produto = $produtorepository->find($id);
        $logProduto = new LogProduto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $imagem = $form->get('img')->getData();
            $imagemData = base64_encode(file_get_contents($imagem->getPathname()));
            $produto->setimg($imagemData);

            $logProduto->setAcao('Editar');
            $logProduto->setProduto($produto);
            $logProduto->setNomeProduto($produto->getNome());
            $logProduto->setCategoria($produto->getCategoria());
            $logProduto->setValorProduto($produto->getValor());
            $logProduto->setQuantidadeProduto($produto->getQuantidade());
            $logProduto->setData(new \DateTime());
            $logProduto->setStatus($produto->getStatus());
            $em->persist($logProduto);

            $em->persist($produto);
            $em->flush();
            $msg = 'Joia atualizada com sucesso';

        }
        $data['titulo'] = 'Editar joia';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/form.html.twig', $data);
     }

     #[Route('produto/excluir', name:'categoria/excluir')]

     public function excluir($id, EntityManagerInterface $em, ProdutoRepository $produtorepository) : Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $produto = $produtorepository->find($id);

        $em->remove($produto); 
        $em->flush(); 

        return $this->redirectToRoute('produto');
     }

     public function adicionarQuantidade(Request $request, $id, $quantidade, EntityManagerInterface $em, ProdutoRepository $produtoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $produto = $produtoRepository->find($id);
        $logProduto = new LogProduto();
        $quantidade = $request->request->get('quantidade'.$id, 1);

        // Adicione a quantidade ao produto
        $produto->setQuantidade($produto->getQuantidade() + $quantidade);

        $logProduto->setAcao('Editar');
        $logProduto->setProduto($produto);
        $logProduto->setNomeProduto($produto->getNome());
        $logProduto->setCategoria($produto->getCategoria());
        $logProduto->setValorProduto($produto->getValor());
        $logProduto->setQuantidadeProduto($produto->getQuantidade());
        $logProduto->setData(new \DateTime());
        $logProduto->setStatus($produto->getStatus());
        $em->persist($logProduto);

        $em->persist($produto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    public function removerQuantidade(Request $request, $id, $quantidade, EntityManagerInterface $em, ProdutoRepository $produtoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $produto = $produtoRepository->find($id);
        $logProduto = new LogProduto();
        $quantidade = $request->request->get('quantidade'.$id, 1);

        $quantidade = min($quantidade, $produto->getQuantidade());

        $produto->setQuantidade($produto->getQuantidade() - $quantidade);

        $logProduto->setAcao('Editar');
        $logProduto->setProduto($produto);
        $logProduto->setNomeProduto($produto->getNome());
        $logProduto->setCategoria($produto->getCategoria());
        $logProduto->setValorProduto($produto->getValor());
        $logProduto->setQuantidadeProduto($produto->getQuantidade());
        $logProduto->setData(new \DateTime());
        $logProduto->setStatus($produto->getStatus());
        $em->persist($logProduto);

        $em->persist($produto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    public function alterarStatus($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $produto = $produtoRepository->find($id);
        
        if($produto->getStatus() == 'Ativo'){
            $produto->setStatus('Inativo');
            $em->persist($produto);
            $em->flush();
        } elseif($produto->getStatus() == 'Inativo')
        {
            $produto->setStatus('Ativo');
            $em->persist($produto);
            $em->flush();
        }

        $logProduto = new LogProduto();
        $logProduto->setAcao('Editar');
        $logProduto->setProduto($produto);
        $logProduto->setNomeProduto($produto->getNome());
        $logProduto->setCategoria($produto->getCategoria());
        $logProduto->setValorProduto($produto->getValor());
        $logProduto->setQuantidadeProduto($produto->getQuantidade());
        $logProduto->setData(new \DateTime());
        $logProduto->setStatus($produto->getStatus());
        $em->persist($logProduto);
        
        $em->persist($produto);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}

