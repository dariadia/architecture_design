<?php
namespace Controller;

class ProductInfoController extends BaseController
{
    /**
     * Информация о продукте
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function infoAction(Request $request, string $id): Response
    {
        $basket = (new Basket($request->getSession()));

        if ($request->isMethod(Request::METHOD_POST)) {
            $basket->addProduct((int)$request->request->get('product'));
        }

        $productInfo = (new ProductService())->getInfo((int)$id);

        if ($productInfo === null) {
            return $this->render('error404.html.php');
        }

        $isInBasket = $basket->isProductInBasket($productInfo->getId());

        return $this->render(
            'product/info.html.php',
            ['productInfo' => $productInfo, 'isInBasket' => $isInBasket]
        );
    }
}