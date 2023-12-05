<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdmEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comissao', TextType::class, [
                'label' => 'Porcentagem de comissão'
            ])
            ->add('limite', TextType::class, [
                'label' => 'Limite do pedido'
            ])
            ->add('Salvar', SubmitType::class);
        ;
    }

    
}