<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Enclosure;
use App\Factory\DinosaurFactory;

class DefaultController extends AbstractController
{
    /**
      * @Route("/", name="homepage") 
      */
    public function indexAction()
    {
        $enclosures = $this->getDoctrine()
            ->getRepository(Enclosure::class)
            ->findAll();

        return $this->render('default/index',[
            'enclosures' => $enclosures
        ]);
    }

     /**
     * @Route("/grow", name="grow_dinosaur",methods="POST")
     */
    public function growAction(DinosaurFactory $dinosaurFactory)
    {
        $manager = $this->getDoctrine()->getManager();

        $enclosure = $manager->getRepository(Enclosure::class)
            ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');
        $dinosaur = $dinosaurFactory->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $manager->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('homepage');
    }
}