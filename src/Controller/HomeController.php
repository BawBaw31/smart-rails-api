<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/csv", name="about", methods={"GET"})
     */
    public function csv(SerializerInterface $serializer): Response
    {
        $csvFile = $serializer->serialize(
            [
                ['name' => 'John', 'age' => '30'],
                ['name' => 'Jane', 'age' => '25'],
            ],
            'csv'
        );

        return new Response(
            $csvFile,
            200,
            [
                //Définit le contenu de la requête en tant que fichier Excel
                'Content-Type' => 'application/vnd.ms-excel',
                //On indique que le fichier sera en attachment donc ouverture de boite de téléchargement ainsi que le nom du fichier
                "Content-disposition" => "attachment; filename=TestCsv.csv"
            ]
        );
    }
}
