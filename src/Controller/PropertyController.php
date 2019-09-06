<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */

    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response
    {


        // ENVOI DUN ELEMENT EN BDD
        /*$property = new Property();

        $property->setTitle('Mon premier bien')
            ->setPrice('200000')
            ->setRooms('3')
            ->setBedrooms('3')
            ->setDescription('Description')
            ->setSurface('60')
            ->setFloor('4')
            ->setHeat('1')
            ->setCity('Montpellier')
            ->setAddress('Boulevard Gambetta')
            ->setPostalCode('34000');

        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();*/

        $property = $this->repository->findAllVisible();
        dump($property);

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {

        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}