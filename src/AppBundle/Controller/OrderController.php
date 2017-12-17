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
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/create", name="create")
     * @Method({"GET"})
     */
    public function create()
    {
        return $this->render('default/create.html.twig');
    }

    /**
     * @Route("/create", name="pizza-create")
     * @Method({"POST"})
     */
    public function postCreate(Request $request)
    {
        $values = $request->request->all();

        if ($this->orderRepository->createNewOrder($values)) {
            return $this->redirectToRoute("thank-you");
        }

        $this->addFlash('errors', 'Something went wrong. Please try again!');

        return $this->redirectToRoute('create');
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

    /**
     * @Route("/find", name="find")
     */
    public function find()
    {
        return $this->render('default/find.html.twig');
    }

    /**
     * @Route("/list", name="list")
     */
    public function listSearch(Request $request)
    {

        if (!$request->query->has('phone_number')) {
            return $this->redirectToRoute('find');
        }

        $number = str_replace("-", "", $request->query->get("phone_number"));
        $list = $this->orderRepository->findBy(['phone_number' => $number]);

        return $this->render('default/list.html.twig', [
            'orders' => $list
        ]);
    }
}
