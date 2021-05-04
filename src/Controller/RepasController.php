<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Form\RepasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepasController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/repas", name="repas")
     */
    public function index(Request $request): Response
    {
        $repas = new Repas();
        $form = $this->createForm(RepasType::class, $repas, ['groupe' => $request->request->get('repas')['groupe'] ?? null, 'sousGroupe' => $request->request->get('repas')['sousGroupe'] ?? null]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($repas->getAliments())) {
                $this->addFlash('success', 'Repas created');
                $this->entityManager->persist($repas);
                $this->entityManager->flush();

                $repas = new Repas();
                $form = $this->createForm(RepasType::class, $repas);
                return $this->render('repas/index.html.twig', [
                    'controller_name' => 'RepasController',
                    'form' => $form->createView()
                ]);
            }

        }
        return $this->render('repas/index.html.twig', [
            'controller_name' => 'RepasController',
            'form' => $form->createView()
        ]);
    }
}
