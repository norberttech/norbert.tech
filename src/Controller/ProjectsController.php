<?php

namespace NorbertTech\Portfolio\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProjectsController extends AbstractController
{
    public function list(): Response
    {
        return $this->render('projects/list.html.twig', []);
    }
}
