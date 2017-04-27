<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Repository\Contract\PersonRepository;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route(service="app.api_person_controller")
 */
class PersonController extends Controller
{
    protected $container;
    protected $people;
    public function __construct(Container $container, PersonRepository $people)
    {
        $this->container = $container;
        $this->people = $people;
    }

    /**
     * Response with all Person registered on the database
     *
     * @ApiDoc(
     *  section="Person",
     *  resource=true,
     *  description="Retrieves a list of person",
     *  output="AppBundle\Entity\Person",
     *  statusCodes={
     *         200="Returned when successful",
     *         504="Returned when request is bad",
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *  }
     * )
     *
     * @Route("/api/people", name="api-person-index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/javascript');

        $serializer = $this->container->get('jms_serializer');
        $people = [];
        try {
            $criteria = $request->query->all();
            $people = count($criteria) ? $this->people->findBy($criteria) : $this->people->findAll();
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($serializer->serialize(['error' => 'Problem fetching data.'], 'json'));
        }

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($serializer->serialize($people, 'json'));

        return $response;
    }

    /**
     * Response with one Person registered on the database
     *
     * @ApiDoc(
     *  section="Person",
     *  resource=true,
     *  description="Retrieves a single person",
     *  output="AppBundle\Entity\Person",
     *  statusCodes={
     *         200="Returned when successful",
     *         504="Returned when request is bad",
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *  }
     * )
     * @Route("/api/people/{id}", name="api-person-show")
     * @Method("GET")
     */
    public function showAction($id, Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/javascript');
        $serializer = $this->container->get('jms_serializer');

        try {
            $criteria = $request->query->all();
            $person = $this->people->findById($id, $criteria);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($serializer->serialize(['error' => 'Problem fetching data.'], 'json'));
        }

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($serializer->serialize($person, 'json'));

        return $response;
    }
}
