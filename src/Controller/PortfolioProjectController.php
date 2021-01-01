<?php

namespace App\Controller;

use App\Entity\PortfolioImages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PortfolioProject;
use App\Form\PortfolioFormType;

class PortfolioProjectController extends AbstractController
{
    /**
     * @Route("/portfolioProject", name="portfolioProject")
     */
    public function index(): Response
    {
        return $this->render('portfolioProject/listProject.html.twig', [
            'controller_name' => 'PortfolioProjectController',
        ]);
    }
    /**
     * @Route("/addPortfolioProject", name="addPortfolioProject")
     */
    public function addPortfolioProject(Request $request){
        
        $PortfolioProject = new PortfolioProject();
        $formProject = $this->createForm(PortfolioFormType::class,$PortfolioProject);
        $formProject->handleRequest($request);
        if($formProject->isSubmitted()){

            $images = $formProject->get('upload')->getData();
            foreach($images as $image){
                //pour gere le nom du fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //pour mettre le fichier dans le repertoire
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //pour stocker l'image dans la bdd
                $img = new PortfolioImages;
                $img->setName($fichier);
                $PortfolioProject->addPortfolioImage($img);

            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($PortfolioProject);
            $em->flush();
            return $this->redirectToRoute("portfolioProject");
        }
 
        return $this->render("portfolioProject/addProject.html.twig",array('formProject'=>$formProject->createView()));
    }

    /**
     * @Route("/portfolioProject", name="portfolioProject")
     */
    public function listPortfolioProject()
    {
        $Project=$this->getDoctrine()->getRepository(PortfolioProject::class)->findAll();
        return $this->render("portfolioProject/listProject.html.twig",array('listProject'=>$Project));

    }
    /**
     * @Route("/detailPortfolioProject/{id}", name="detailPortfolioProject")
     */
    public function showPortfolioProject($id)
    {
        $Project=$this->getDoctrine()->getRepository(PortfolioProject::class)->find($id);
        return $this->render("portfolioProject/detailProject.html.twig",array('project'=>$Project));

    }
}
