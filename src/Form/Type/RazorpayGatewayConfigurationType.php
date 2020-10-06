<?php

namespace Srkits\SyliusRazorPayPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Hlib Synkovskyi <gleb.sinkovskiy@gmail.com>
 */
final class RazorpayGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('api_key', TextType::class, [
                'label' => 'API Key',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter API key',
                        'groups' => ['sylius'],
                    ])
                ],
            ])
            ->add('api_secret', TextType::class, [
                'label' => 'API Secret',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter API Secret',
                        'groups' => ['sylius'],
                    ])
                ],
            ])
        ;
    }
}