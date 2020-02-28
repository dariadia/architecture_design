<?php

declare(strict_types=1);

namespace Controller;

use Framework\BaseController;
use Service\Order\Basket;
use Service\Product\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductListController extends BaseController
{
    /**
     * Список всех продуктов
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $productList = (new ProductService())->getAll(
            $request->query->get('sort', '')
        );

        return $this->render(
            'product/list.html.php',
            ['productList' => $productList]
        );
    }
}
