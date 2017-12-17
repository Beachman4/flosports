<?php

namespace AppBundle\Controller;

use AppBundle\Repository\OrderRepository;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class OrderRestControllerController extends Controller
{
    private $orderRepository;

    /**
     * OrderRestControllerController constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Get("/api/orders")
     */
    public function getOrders(Request $request)
    {
        if ($request->query->has('phone_number')) {
            $number = str_replace("-", "", $request->query->get("phone_number"));

            $list = $this->orderRepository->findBy(['phone_number' => $number]);

            return new JsonResponse($list);
        }


        return new JsonResponse($this->orderRepository->findAll());
    }

    /**
     *
     * @RequestParam(name="first_name", requirements="[A-Za-z]+")
     *
     * @RequestParam(name="last_name", requirements="[A-Za-z]+")
     *
     * @RequestParam(name="phone_number", requirements="[0-9]+")
     *
     * @RequestParam(map=true, name="toppings", requirements="[a-z]+")
     *
     * @RequestParam(name="type", requirements="[a-z]+")
     *
     * @Post("/api/orders")
     */
    public function createOrder(ParamFetcher $paramFetcher)
    {
        $values = $paramFetcher->all();

        if ($order = $this->orderRepository->createNewOrder($values)) {
            return new JsonResponse($order);
        }

        $error = [
            "status" => "failed",
            "message" => "An error occurred"
        ];

        return new JsonResponse($error, 500);
    }
}
