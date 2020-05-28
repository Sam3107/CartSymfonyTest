<?php
namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/checkout")
     */
    public function checkout(Request $request)
    {
        Stripe::setApiKey('sk_test_iVIe1TqDZbaAebA8IvzYbJoS005YDDkaXE');
/*
        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => [],
            'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost:8000/cart_index',
        ];
        
        foreach ($this->session->get('panier') as $item) {
            $sessionData['line_items'][] = [
                
                'description' => 'Votre total',
                'amount' =>($item['price'] * 100),
                'currency' => 'eur',
                'quantity' => 1
            ];
            dd($this->session);
        }

        $session = Session::create($sessionData);
*/

$sessionData = [
    'payment_method_types' => ['card'],
    'line_items' => [[
    'price' => $_POST['total'],
    'quantity' => 1,
    ]],
    //'mode' => 'payment',
    'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'https://example.com/cancel',
];
        $session = Session::create($sessionData);
        return $this->render('cart/checkout.html.twig', [

            'sessionId' => $session->id
        ]);
    }
}