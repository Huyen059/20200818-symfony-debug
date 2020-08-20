<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    /**
     * @Route("/credit", name="add_credit")
     */
    public function index(Request $request)
    {

        $user = $this->getUser();
        if($request->request->get('credit')){
            $user->setCredit($user->getCredit() + $request->request->get('credit'));
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('credit/index.html.twig');
    }
}
