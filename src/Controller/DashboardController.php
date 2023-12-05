<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $dataInicio = $request->query->get('dataInicio');
        $dataFim = $request->query->get('dataFim');

        if($dataInicio && $dataFim){
            $query = $em->createQuery('
                SELECT
                    u.nome,
                    COALESCE(SUM(lvi.quantidade * lvi.valor), 0) AS totalValorVendas,
                    COALESCE(SUM(lvi.quantidade), 0) AS totalQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade * lvi.valor)/ NULLIF(SUM(lvi.quantidade), 0), 0) AS mediaValorVendas,
                    COALESCE(SUM(lvi.valor) / (MAX(lv.numeroCarrinho)), 0) AS mediaQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade) / (MAX(lv.numeroCarrinho)), 0) AS mediaItensPorCarrinho
                FROM App\Entity\Usuario u
                LEFT JOIN u.carrinho c
                LEFT JOIN c.logVendas lv
                LEFT JOIN lv.logVendasItems lvi
                WHERE (lv.id IS NOT NULL)
                AND (:dataInicio IS NULL OR lv.data BETWEEN :dataInicio AND :dataFim)
                AND (:dataInicio IS NOT NULL OR :dataFim IS NOT NULL)
                AND u.estadoAtual = :estadoAtualAtivo
                GROUP BY u.nome
            ');

            $query->setParameter('dataInicio', $dataInicio ? new \DateTime($dataInicio) : null);
            $query->setParameter('dataFim', $dataFim ? new \DateTime($dataFim) : null);
            $query->setParameter('estadoAtualAtivo', 'Ativo');

            $produtosMaisVendidosQuery = $em->createQuery('
                SELECT
                    p.nome,
                    COALESCE(SUM(lvi.quantidade), 0) AS totalQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade * lvi.valor), 0) AS totalValorVendas
                FROM App\Entity\Produto p
                LEFT JOIN p.logVendasItems lvi
                LEFT JOIN lvi.logVenda lv
                WHERE (lvi.id IS NOT NULL)
                AND (:dataInicio IS NULL OR lv.data BETWEEN :dataInicio AND :dataFim)
                AND (:dataInicio IS NOT NULL OR :dataFim IS NOT NULL)
                AND p.status = :statusAtivo
                GROUP BY p.nome
                ORDER BY totalQuantidadeVendida DESC
            ');

            $produtosMaisVendidosQuery->setParameter('dataInicio', $dataInicio ? new \DateTime($dataInicio) : null);
            $produtosMaisVendidosQuery->setParameter('dataFim', $dataFim ? new \DateTime($dataFim) : null);
            $produtosMaisVendidosQuery->setParameter('statusAtivo', 'Ativo');
        } else{
            $query = $em->createQuery('
                SELECT
                    u.nome,
                    COALESCE(SUM(lvi.quantidade * lvi.valor), 0) AS totalValorVendas,
                    COALESCE(SUM(lvi.quantidade), 0) AS totalQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade * lvi.valor)/ NULLIF(SUM(lvi.quantidade), 0), 0) AS mediaValorVendas,
                    COALESCE(SUM(lvi.quantidade * lvi.valor) / (MAX(lv.numeroCarrinho)), 0) AS mediaQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade) / (MAX(lv.numeroCarrinho)), 0) AS mediaItensPorCarrinho
                FROM App\Entity\Usuario u
                LEFT JOIN u.carrinho c
                LEFT JOIN c.logVendas lv
                LEFT JOIN lv.logVendasItems lvi
                WHERE (lv.id IS NOT NULL)
                AND u.estadoAtual = :estadoAtualAtivo
                GROUP BY u.nome
            ');

           

            $query->setParameter('estadoAtualAtivo', 'Ativo');

            $produtosMaisVendidosQuery = $em->createQuery('
                SELECT
                    p.nome,
                    COALESCE(SUM(lvi.quantidade), 0) AS totalQuantidadeVendida,
                    COALESCE(SUM(lvi.quantidade * lvi.valor), 0) AS totalValorVendas
                FROM App\Entity\Produto p
                LEFT JOIN p.logVendasItems lvi
                LEFT JOIN lvi.logVenda lv
                WHERE (lvi.id IS NOT NULL)
                AND p.status = :statusAtivo
                GROUP BY p.nome
                ORDER BY totalQuantidadeVendida DESC
            ');

            $produtosMaisVendidosQuery->setParameter('statusAtivo', 'Ativo');
        }
            
        $dashboardData = $query->getResult();


        $produtosMaisVendidos = $produtosMaisVendidosQuery->getResult();

        return $this->render('dashboard/index.html.twig', [
            'dashboardData' => $dashboardData,
            'produtosMaisVendidos' => $produtosMaisVendidos,
        ]);
    }
}