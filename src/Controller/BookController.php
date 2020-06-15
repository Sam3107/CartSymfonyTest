<?php

namespace App\Controller;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index")
     */
    public function index(PaginatorInterface $paginator, Request $request, BookRepository $bookRepository)
    {
        return $this->render('book/index.html.twig', [
           // 'books' => "tous les books"
            'books' => $paginator->paginate($bookRepository->findAll(),$request->query->getInt('page', 1), 6)
        ]);
    }



    /**
 * Permet d'afficher un seul livre
 * 
 * @Route("/book/{slug}", name="book_show")
 * 
 * @return Response
 * 
 */

public function show($slug, BookRepository $repo){

    //je recupere l'annonce qui correspond au slug !

    $book = $repo->findOneBySlug($slug);

    return $this->render('book/show.html.twig', [

        'book' => $book
    ]
    );       
}

}
