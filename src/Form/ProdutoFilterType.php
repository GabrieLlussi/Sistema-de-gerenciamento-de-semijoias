<?php


namespace App\Form;

use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProdutoFilterType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categorias = $this->entityManager->getRepository(Categoria::class)->findAll();

        $choices = [];
        foreach ($categorias as $categoria) {
            $choices[$categoria->getNome()] = $categoria;
        }

        $builder
            ->add('categoria', ChoiceType::class, [
                'choices' => $choices,
                'required' => false,
                'placeholder' => 'Todas as Categorias',
            ])
            ->add('Filtrar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure as opções, se necessário
        ]);
    }
}