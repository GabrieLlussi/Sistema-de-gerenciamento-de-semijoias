<?php

namespace App\Form;

use App\Entity\Regiao;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Concordo com os termos de uso',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Senha',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor insira sua senha',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('endereco', TextType::class, [
                'label' => 'Endereço',
            ])
            ->add('telefone')
            ->add('cpf', TextType::class, [
                'label' => 'CPF',
            ])
            ->add('regiao', EntityType::class, [
                'class' => Regiao::class,
                'choice_label' => 'nome',
                'label' => 'Região: '
            ])
            ->add('comissao', TextType::class, [
                'label' => 'Porcentagem de comissão'
            ])
            ->add('limite', TextType::class, [
                'label' => 'Limite do pedido'
            ])
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
