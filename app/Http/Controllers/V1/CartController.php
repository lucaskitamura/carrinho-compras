<?php

namespace App\Http\Controllers\V1;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\CartException;
use App\Services\V1\Contracts\CartServiceContract;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartServiceContract $cart)
    {
        $this->cart = $cart;
    }
    public function list(int $userId): JsonResponse
    {
        try {
            $list = $this->cart->listAllProducts($userId);

            if ($list) {
                return response()->json(
                    [
                        'message' => 'Operation success',
                        'data' => $list
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (CartException $e) {
            return response()->json([
                'message' => $e->getMessage()
           ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error, try later'
           ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
