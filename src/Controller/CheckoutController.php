<?php
namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Service\Cart\CartService;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
require_once('C:\CartSymfonyTest\Livre\vendor\stripe\stripe-php/init.php');
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
        
        Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);
/*
        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => [],
            'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => http://localhost':8000/cart_index',
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
    'name' => 'total' ,  
    'amount' => ($_POST['total'])*100,
    'currency' => 'eur',
    'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost:8000/panier',
];


        $session = Session::create($sessionData);
        
        return $this->render('cart/checkout.html.twig', [

            'sessionId' => $session['id']
        
        ]);
    
    }

    /**
     * @Route("/vider", name="vider")
     */

    public function emptyCart(PaginatorInterface $paginator, Request $request, BookRepository $bookRepository){
        $session = session_destroy();
        return $this->render('book/index.html.twig', [
            // 'books' => "tous les books"
            'books' => $paginator->paginate($bookRepository->findAll(),$request->query->getInt('page', 1), 6)
        ]);

    }

}

