<?php

namespace App\Controller;

use App\Entity\PortfolioImages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\PortfolioFormType;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
    /**
     * @Route("/addProject", name="addProject")
     */
    public function addProject(Request $request){
        
        $project = new Project();
        $formProject = $this->createForm(PortfolioFormType::class,$project);
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
                $project->addPortfolioImage($img);

            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute("project");
        }
 
        return $this->render("project/addProject.html.twig",array('formProject'=>$formProject->createView()));
    }

    /**
     * @Route("/project", name="project")
     */
    public function listProject()
    {
        $project=$this->getDoctrine()->getRepository(Project::class)->findAll();
        return $this->render("project/listProject.html.twig",array('listProject'=>$project));

    }
    /**
     * @Route("/detailProject/{id}", name="detailProject")
     */
    public function showProject($id)
    {
        $project=$this->getDoctrine()->getRepository(Project::class)->find($id);
        return $this->render("project/detailProject.html.twig",array('project'=>$project));

    }
}
