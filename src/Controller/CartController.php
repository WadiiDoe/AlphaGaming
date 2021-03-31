<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     * @param SessionInterface $session
     * @param $produitRepository
     * @return Response
     */
    public function index(SessionInterface $session , ProduitRepository $produitRepository): Response
    {
        $panier=$session->get('panier',[]);
        $panierWithData=[];
        foreach ($panier as $id=> $quantity){

            $panierWithData[]= [
                'produit'=>$produitRepository->find($id),
                'quantity' =>$quantity
            ];

        }
        $total=0;
        foreach ($panierWithData as $item ){

            $totalItem = $item['produit']->getPrix()*$item['quantity'];
            $total+= $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'items'=>$panierWithData,
            'total'=>$total
        ]);
    }


    /**
     * @Route ("/panier/add/{id}", name="cart_add")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function add($id, SessionInterface $session ): RedirectResponse
    {

     $panier =$session->get('panier',[]);
     if(!empty($panier[$id])){
         $panier[$id]++;
     } else {
         $panier[$id]= 1;
     }

     $session->set('panier',$panier);
     return $this->redirectToRoute("cart_index");

    }

    /**
     * @Route ("/panier/remove/{id}", name="cart_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id,SessionInterface $session): RedirectResponse
    {
        $panier =$session->get('panier',[]);
if(!empty($panier[$id])){
    unset($panier[$id]);

}
$session->set('panier',$panier);
return $this->redirectToRoute("cart_index");
    }
}
