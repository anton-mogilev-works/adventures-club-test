<?php

namespace App\Form;

use App\Entity\Calculation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class CalculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        //Валидатор для обоих аргументов
        $assertValueCallback = function(mixed $value, ExecutionContextInterface $context) : void {
            if(is_numeric($value) == false) {
                $context->buildViolation('Поле должно содержать только число')                    
                    ->addViolation();
            }
        };

        //Преобразователь для обоих аргументов
        $valueCallbackTransformer = new CallbackTransformer(
            function (mixed $value) : string {                   
                return (string) $value;
            },
            function (mixed $value) : float | null {

                if(is_numeric($value)) {
                    return (float) $value;
                }
                
                return null;
            }
        );

        $builder
            ->add('value_1', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'form-block'
                ],
                'label' => 'Аргумент 1',
                'constraints' => [new Assert\Callback($assertValueCallback)]
            ])
            ->add('mathematical_action', ChoiceType::class, [
                'required' => true,
                'row_attr' => [
                    'class' => 'form-block'
                ],
                'label' => 'Операция',
                'choices'  => [
                    '+' => '+',
                    '-' => '-',
                    '*' => '*',
                    '/' => '/',
                ]
            ])
            ->add('value_2', TextType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'form-block'
                ],
                'label' => 'Аргумент 2',
                'constraints' => [new Assert\Callback($assertValueCallback)]
            ])
            ->add('calculate', SubmitType::class, [
                'label' => 'Вычислить',
                'row_attr' => [
                    'class' => 'form-block'
                ],
            ])
            ->add('in_queue', SubmitType::class, [
                'label' => 'В очередь',
                'row_attr' => [
                    'class' => 'form-block'
                ],
            ])
            ;

            $builder->get('value_1')->addModelTransformer($valueCallbackTransformer);       
            $builder->get('value_2')->addModelTransformer($valueCallbackTransformer);       
    }

   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calculation::class,
        ]);
    }
}
