<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Repository\Contract\OrderRepository;

/**
 * @Route(service="app.api_order_controller")
 */
class OrderController extends Controller
{
    protected $container;
    protected $orders;
    public function __construct(Container $container, OrderRepository $orders)
    {
        $this->container = $container;
        $this->orders = $orders;
    }

    /**
     * @Route("/api/orders", name="api-order-index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/javascript');

        $serializer = $this->container->get('jms_serializer');

        try {
            $criteria = $request->query->all();
            $orders = count($criteria) ? $this->orders->findBy($criteria) : $this->orders->findAll();
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($serializer->serialize(['error' => 'Problem fetching data.'], 'json'));
        }

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($serializer->serialize($orders, 'json'));

        return $response;
    }

    /**
     * @Route("/api/orders/{id}", name="api-order-show")
     * @Method("GET")
     */
    public function showAction($id, Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/javascript');
        $serializer = $this->container->get('jms_serializer');

        try {
            $criteria = $request->query->all();
            $order = $this->orders->findById($id, $criteria);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($serializer->serialize(['error' => 'Problem fetching data.'], 'json'));
        }

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($serializer->serialize($order, 'json'));

        return $response;
    }
}
