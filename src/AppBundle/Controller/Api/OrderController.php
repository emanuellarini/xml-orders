<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * @Route("/api/orders")
     * @Method("GET")
     */
    public function indexAction()
    {
        $serializer = $this->container->get('jms_serializer');
        $orders = $this->getDoctrine()->getRepository('AppBundle:Order')->findAll();
        $response = new Response($serializer->serialize($orders, 'json'));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}
