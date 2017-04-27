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
        $template = $this->container->get('twig')->render('default/index.html.twig', [ 'messages' => '' ]);

        return new Response($template);
    }

    /**
     * @Route("/import", name="import-create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $errors = [];
        if (!$request->files->get('people')) {
            $errors[] = 'File field People is mandatory.';
        }
        if (!$request->files->get('shiporders')) {
            $errors[] = 'File field Orders is mandatory.';
        }

        if (count($errors)) {
            $template = $this->container->get('twig')->render('default/index.html.twig', ['messages' => $errors, 'type' => 'danger']);
            return new Response($template);
        }

        $peopleXml = $request->files->get('people')->getPathname();
        $ordersXml = $request->files->get('shiporders')->getPathname();
        $people = new \SimpleXMLElement(file_get_contents($peopleXml));
        $orders = new \SimpleXMLElement(file_get_contents($ordersXml));

        try {
            $peopleData = $this->xmlHandler->getPeople($people);
            $ordersData = $this->xmlHandler->getOrders($orders);
            $this->xmlHandler->createData($ordersData, $peopleData);
        } catch (\Exception $e) {
            $template = $this->container->get('twig')->render('default/index.html.twig', ['messages' => ['Failed to parse and persist XML data.'], 'type' => 'danger']);
            return new Response($template);
        }

        $template = $this->container->get('twig')->render('default/index.html.twig', ['messages' => ['Xmls imported succesfully.'], 'type' => 'success']);
        return new Response($template);
    }
}
