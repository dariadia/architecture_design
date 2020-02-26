<?php

namespace Service\Product\Sort;

class SortProductsController
{
    /**
     * Обрабатываем запрос со страницы product/list.html
     * @param $url
     * @throws \Exception
     */
    public function get(string $url): void
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (preg_match('#^/product_list?$#', $path, $matches)) {
            // .....
        } else {
            echo "Controller: 404 page\n";
        }
        $sortMethod = SortProductsFactory::getSortMethod( //matches as $method
        );
    }
}

/**
 * В этом классе выбор объектов стратегии для осуществления сортировки
 */
class SortProductsFactory
{
    /**
     * Получаем метод сортировки
     * @param $method
     * @return SortMethod
     * @throws \Exception
     */
    public static function getSortMethod(string $method): SortMethod
    {
        switch ($method) {
            case "name":
                return new NameSort;
            case "price":
                return new PriceSort;
            default:
                return new NameSort;
        }
    }
}

/**
 * Интерфейс Стратегии 
 */
interface SortMethod
{
    public function getSortMethod($method): string;
}

/**
 * Стратегия сортировки по названию продукта
 */
class NameSort implements SortMethod
{
    public function getSortMethod($method)
    {
        echo 'something happends here and sort products by name';
    }
}

/**
 * Стратегия сортировки по price продукта
 */
class PriceSort implements SortMethod
{
    public function getPaymentForm($method)
    {
        echo 'something happends here and sort products by price';
    }
}
