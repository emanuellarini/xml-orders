<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    /**
     * @Route("/api/people")
     * @Method("GET")
     */
    public function indexAction()
    {
        $serializer = $this->container->get('jms_serializer');
        $people = $this->getDoctrine()->getRepository('AppBundle:Person')->findAll();
        $response = new Response($serializer->serialize($people, 'json'));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}
