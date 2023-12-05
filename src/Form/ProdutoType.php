<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, ['label' => 'Nome do produto: '])
            ->add('descricao', TextType::class, ['label' => 'Descrição do produto:'])
            ->add('valor', TextType::class, ['label' => 'Valor: '])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'Nome',
                'label' => 'Categoria: '
            ])
            ->add('img', FileType::class, [
                'label' => 'Escolher Imagem',
                'mapped' => false, // Este campo não está mapeado diretamente para a entidade
                'required' => false, // Tornar o upload de imagem opcional
            ])
            
            ->add('Salvar', SubmitType::class);
    }
}