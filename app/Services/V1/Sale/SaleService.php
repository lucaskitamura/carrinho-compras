<?php

namespace App\Services\V1\Sale;

use Carbon\Carbon;
use App\Jobs\UpdateProductsQuantity;
use App\Services\V1\Contracts\CartServiceContract;
use App\Services\V1\Contracts\SaleServiceContract;
use App\Repositories\Contracts\SaleRepositoryContract;
use App\Services\V1\Contracts\CreditCardServiceContract;

class SaleService implements SaleServiceContract
{
    private $saleRepositoryContract, $cartServiceContract, $creditCardServiceContract;

    public function __construct(
        SaleRepositoryContract $saleRepositoryContract,
        CartServiceContract $cartServiceContract,
        CreditCardServiceContract $creditCardServiceContract
    ) {
        $this->saleRepositoryContract = $saleRepositoryContract;
        $this->cartServiceContract = $cartServiceContract;
        $this->creditCardServiceContract = $creditCardServiceContract;
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        $cart = $this->cartServiceContract->listAllProducts($data['user_id']);
        $cartProductsSum = $this->cartServiceContract->getCartProductsSum($cart);

        $data = [
            'user_id' => $data['user_id'],
            'user_name' => $data['user_name'],
            'credit_card_id' => $data['credit_card_id'],
            'amount' => $cartProductsSum,
            'date' => Carbon::now()->format('Ymd')
        ];

        $this->removeProductsQuantity($cart);
        $this->cartServiceContract->removeCartCache($data['user_id']);

        return $this->saleRepositoryContract->store($data);
    }

    /**
     * @param object $cart
     */
    private function removeProductsQuantity($cart)
    {
        UpdateProductsQuantity::dispatch($cart);
    }

    public function list()
    {
        $sales = $this->saleRepositoryContract->all();
        return $this->mountReturnBody($sales);
    }

    /**
     * @param int $userId
     */
    public function listByUserId(int $userId)
    {
        $sales = $this->saleRepositoryContract->listByUserId($userId);
        return $this->mountReturnBody($sales);
    }

    /**
     * @param $sales
     */
    private function mountReturnBody($sales)
    {
        return $sales->map(function ($saleItem) {
            $saleItem['credit_card_number'] = $this->creditCardServiceContract->creditCardMasking($saleItem->CreditCard->card_number);
            unset($saleItem['credit_card_id']);
            unset($saleItem['created_at']);
            unset($saleItem['updated_at']);

            return $saleItem->unsetRelation('CreditCard');
        });
    }
}
