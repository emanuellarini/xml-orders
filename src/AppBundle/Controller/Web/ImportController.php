<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\XmlHandler;

/**
 * @Route(service="app.import_controller")
 */
class ImportController extends Controller
{
    protected $container;
    protected $xmlHandler;
    public function __construct(Container $container, XmlHandler $xmlHandler)
    {
        $this->container = $container;
        $this->xmlHandler = $xmlHandler;
    }

    /**
     * @Route("/", name="import-index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $template = $this->container->get('twig')->render('default/index.html.twig');

        return new Response($template);
    }

    /**
     * @Route("/import", name="import-create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $peopleXml = $request->files->get('people')->getPathname();
        $ordersXml = $request->files->get('shiporders')->getPathname();
        $people = new \SimpleXMLElement(file_get_contents($peopleXml));
        $orders = new \SimpleXMLElement(file_get_contents($ordersXml));

        try {
            $peopleData = $this->xmlHandler->getPeople($people);
            $ordersData = $this->xmlHandler->getOrders($orders);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode(['error' => 'Failed to parse XML data.']));
            return $response;
        }

        if (!$this->xmlHandler->createData($ordersData, $peopleData)) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode(['error' => "Failed to persist XML data."]));
            return $response;
        }

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent(json_encode(['message' => "Xml imported succesfully!"]));
        return $response;
    }
}
