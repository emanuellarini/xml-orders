<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use SimpleXML;

class ImportController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/import", name="import-create")
     */
    public function createAction(Request $request)
    {
        $peopleXml = $request->files->get('people')->getPathname();
        $ordersXml = $request->files->get('shiporders')->getPathname();

        $people = new \SimpleXMLElement(file_get_contents($peopleXml));
        $orders = new \SimpleXMLElement(file_get_contents($ordersXml));
        $peopleData = $this->getPeople($people);
        $ordersData = $this->getOrders($orders);


        dump($peopleData, $orders, $ordersData);
        die;
        return 1;
    }

    protected function getPeople($people)
    {
        $peopleData = [];
        foreach ($people as $person) {
            $phonesData = [];
            if (!$person->personid && !$person->personname && !$person->phones) {
                continue;
            }

            foreach ($person->phones->phone as $phone) {
                $phonesData[] = (string) $phone;
            }

            $peopleData[] = [
                'id' => $person->personid ? (string) $person->personid : null,
                'name' => $person->personname ? (string) $person->personname : null,
                'phones' => $phonesData,
            ];
        }
        return $peopleData;
    }

    protected function getOrders($orders)
    {
        $orderData = [];
        foreach ($orders as $order) {
            $items = [];
            foreach ($order->items->item as $item) {
                $items[] = (array) $item;
            }
            $orderData[] = [
                'id' => (string) $order->orderid,
                'person' => (string) $order->orderperson,
                'address' => (array) $order->shipto,
                'items' => $items
            ];
        }
        return $orderData;
    }
}
