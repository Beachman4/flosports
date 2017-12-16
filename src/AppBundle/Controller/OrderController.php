<?php

namespace AppBundle\Controller;

use AppBundle\Repository\OrderRepository;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route(service="defaultcontroller")
 */
class OrderController extends Controller
{

    private $orderRepository;

    /**
     * OrderController constructor.
     * @param $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     */
    public function index(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/", name="pizza-create")
     * @Method({"POST"})
     */
    public function postIndex(Request $request)
    {
        $values = $request->request->all();

        if ($this->orderRepository->createNewOrder($values)) {
            return $this->redirectToRoute("thank-you");
        }

        $this->addFlash('errors', 'Something went wrong. Please try again!');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/thank-you", name="thank-you")
     */
    public function thankYou()
    {
        return $this->render('default/thank-you.html.twig', [
            'reallyFarAwayDate' => Carbon::now()->addMonths(rand(1, 6))->diffForHumans()
        ]);
    }

    public function find()
    {
        return $this->render('default/find.html.twig');
    }

    public function listSearch(Request $request)
    {
        $number = str_replace("-", "", $request->query->get("phone_number"));
        $list = $this->orderRepository->findBy(['phone_number', $number]);

        return $this->render('default/list.html.twig', [
            'orders' => $list
        ]);
    }
}
