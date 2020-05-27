<?php

namespace App\Controller;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index")
     */
    public function index(BookRepository $bookRepository)
    {
        return $this->render('book/index.html.twig', [
           // 'books' => "tous les books"
            'books' => $bookRepository->findAll()
        ]);
    }



    /**
 * Permet d'afficher une seule annonce
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
