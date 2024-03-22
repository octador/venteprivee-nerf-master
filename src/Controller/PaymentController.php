<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Delivery;
use Symfony\Component\Security\Core\User\UserInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment-stripe/{id}', name: 'app_stripe')]
    public function stripecheckout(Delivery $delivery)
    {
        \Stripe\Stripe::setApiKey('sk_test_51OwjDI04UZtBH1pM8iGsCXRNocKVhx3oYDff5cR59U8OlFA5sRcDU5IhdSrsRexg9QCCUUQUcLV8URJ8Xoyjw0fb00TlqZtTs2');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' =>[
                    'currency' => 'eur',
                    'unit_amount' => $delivery -> getProduct() ->getPrice(),
                    'product_data' => [
                        'name' => $delivery -> getProduct()->getName()
                    ]
                    ],
                    'quantity' => 1,
                ]
            ],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/confirmation',
            'cancel_url' => $YOUR_DOMAIN ,
        ]);

        return new RedirectResponse($checkout_session->url);
    }
}
