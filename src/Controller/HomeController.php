<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Repository\VoitureRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VoitureRepository $repoVoiture)
    {
        $voitures = $repoVoiture->findAll();

        return $this->render('home/home.html.twig', [
            'voitures' => $voitures
        ]);
    }

    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function newsletter(Request $request, ObjectManager $manager)
    {
        $subscriber = new Subscriber();

        $form = $this->createForm(SubscriberType::class, $subscriber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($subscriber);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'abonné {$subscriber->getEmail()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('newsletter');
        }
        return $this->render('newsletter/newsletter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/a_propos", name="a_propos")
     */
    public function apropos()
    {

        return $this->render('home/a-propos.html.twig');
    }


    /**
     * @Route("/expertise", name="expertise")
     */
    public function expertise()
    {

        return $this->render('home/expertise.html.twig');
    }

    /**
     * @Route("/conciergerie", name="conciergerie")
     */
    public function conciergerie()
    {

        return $this->render('home/conciergerie.html.twig');
    }

    /**
     * @Route("/restauration_de_véhicules", name="restauration_vehicule")
     */
    public function restaurationVehicule()
    {

        return $this->render('home/restauration-vehicules.html.twig');
    }

    /**
     * @Route("/atelier/mécanique", name="atelier_mecanique")
     */
    public function atelierMecanique()
    {

        return $this->render('home/atelier-mecanique.html.twig');
    }

    /**
     * @Route("/atelier/peinture-et-carrosserie", name="atelier_peinture_et_carrosserie")
     */
    public function atelierPeintureCarrosserie()
    {

        return $this->render('home/atelier-carrosserie-peinture.html.twig');
    }
}
