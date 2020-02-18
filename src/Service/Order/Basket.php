<?php

declare(strict_types=1);

namespace Service\Order;

use Model;
use Model\Entity\Product;
use Model\Repository\ProductRepository;
use Service\Billing\Exception\BillingException;
use Service\Billing\BillingInterface;
use Service\Billing\Transfer\Card;
use Service\Communication\Exception\CommunicationException;
use Service\Communication\CommunicationInterface;
use Service\Communication\Sender\Email;
use Service\Discount\DiscountInterface;
use Service\Discount\NullObject;
use Service\User\SecurityInterface;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class BasketBuilder
{
    private $billing;
    private $discount;
    private  $communication;
    private  $security;
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';
    /**
     * @var SessionInterface
     */
    private $session;

    public function getBilling()
    {
        return $this->billing;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getCommunication()
    {
        return $this->communication;
    }

    public function getSecurity()
    {
        return $this->security;
    }

    public function setBilling($billing)
    {
        $this->billing = new Card();
        return $this;
    }

    public function setDiscount($discount)
    {
        $this->discount = new NullObject();
        return $this;
    }

    public function setCommunication($communication)
    {
        $this->communication = new Email();
        return $this;
    }

    public function setSecurity($security)
    {
        $this->security = new Security($this->session);
        return $this;
    }

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     * @param int $productId
     * @return void
     */
    public function addProduct(int $productId): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($productId, $basket, true)) {
            $basket[] = $productId;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     * @param int $productId
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     * @return Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();
        return $this->getProductRepository()->search($productIds);
    }

    /**
     * @return float
     */
    public function calculateProductsTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }
        return $totalPrice;
    }

    /**
     * Фабричный метод для репозитория Product
     * @return ProductRepository
     */
    protected function getProductRepository(): ProductRepository
    {
        return new ProductRepository();
    }

    /**
     * Получаем список id товаров корзины
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }

    public function build(): checkoutProcess
    {
        $basket = $this->setBilling($this->billing)
            ->setDiscount($this->discount)
            ->setCommunication($this->communication)
            ->setSecurity($this->security);
        return new checkoutProcess($basket);
    }
}

class checkoutProcess
{
    /**
     * Проведение всех этапов заказа
     * @param DiscountInterface $discount
     * @param BillingInterface $billing
     * @param SecurityInterface $security
     * @param CommunicationInterface $communication
     * @return void
     * @throws BillingException
     * @throws CommunicationException
     */
    public function checkoutProcess(
        BasketBuilder $basketBuilder
    ): void {
        $basket = $basketBuilder->build();
        $totalPrice = 0;
        foreach ($this->$basket->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }
    }
}
