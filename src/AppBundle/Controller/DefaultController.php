<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 * @Route("/softuni")
 */
class DefaultController extends Controller
{
    /**
     * @Route("", name="homepage")
     * @Template("AppBundle::default.html.twig")
     */
    public function indexAction(Request $request)
    {
        $type = $request->query->get('type', null);
        if ($type === null){
            throw $this->createNotFoundException('No type defined!');
        }
        if ($type == 'fruits'){
            return $this->redirectToRoute('fruits');
        }elseif($type == 'vegetables'){
            return $this->redirectToRoute('vegetables');
        }

        return [];
    }

    /**
     * @Route("/fruits", name="fruits")
     * @Template("AppBundle::default.html.twig")
     */
    public function fruitsAction()
    {
        $fruits = $this->_getFruits();
        $pageTitle = 'Fruits action';

        return ['results' => $fruits, 'pageTitle' => $pageTitle];

    }

    /**
     * @Route("/vegetables", name="vegetables")
     * @Template("AppBundle::default.html.twig")
     */
    public function vegetablesAction()
    {
        $vegetables = $this->_getVegetables();
        $pageTitle = 'Vegetables action';

        return ['results' => $vegetables, 'pageTitle' => $pageTitle];
    }

    /**
     * @return array
     */
    private function _getFruits()
    {
        $fruits = ['apple', 'banana', 'apricot', 'strawberry'];
        return $fruits;
    }

    /**
     * @return array
     */
    private function _getVegetables()
    {
        $vegetables = ['beans', 'peppers', 'cocumber', 'garlic'];
        return $vegetables;
    }

    /**
     * @Route(
     *     "/testformat.{_format}",
     *     name="test_format",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_format": "html|json"
     *     })
     */
    public function testFormatParameterAction(Request $request)
    {
        $fruits = $this->_getFruits();
        $pageTitle = 'Fruits action';
        if ($request->get('_format') == 'json'){
            return new Response(json_encode($fruits));
        }
        return $this->render("AppBundle::default.html.twig", ['results' => $fruits, 'pageTitle' => $pageTitle]);

    }
}
