<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\PortfolioProject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/home", name="home")
*/
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/portfolio", name="homePortfolio")
     */
    public function listPortfolioProject()
    {
        $Project=$this->getDoctrine()->getRepository(PortfolioProject::class)->findAll();
        return $this->render("home/homeProjects.html.twig",array('listProjectHome'=>$Project));

    }
    /**
     * @Route("/blog", name="homeBlog")
     */
    public function showBlog()
    {
        $BlogPost=$this->getDoctrine()->getRepository(BlogPost::class)->findAll();
        return $this->render("home/homeBlog.html.twig",array('listBlogHome'=>$BlogPost));
    }
     
}
