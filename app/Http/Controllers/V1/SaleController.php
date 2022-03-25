<?php

namespace App\Http\Controllers\V1;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\SaleException;
use App\Services\V1\Contracts\SaleServiceContract;
use App\Http\Requests\Sale\SaleStoreRequest;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleServiceContract $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * @param SaleStoreRequest $request
     * @return jsonResponse
     */
    public function store(SaleStoreRequest $request):JsonResponse
    {
        try {
            $saleData = $request->validated();

            if ($this->saleService->store($saleData)) {
                return response()->json(
                    [
                        'message' => 'Operation success'
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (SaleException $e) {
            return response()->json([
                'message' => $e->getMessage()
           ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error, try later'
           ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return jsonResponse
     */
    public function list():JsonResponse
    {
        try {
            $list = $this->saleService->list();

            if ($list) {
                return response()->json(
                    [
                        'message' => 'Operation success',
                        'data' => $list
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (SaleException $e) {
            return response()->json([
                'message' => $e->getMessage()
           ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error, try later'
           ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $userId
     * @return jsonResponse
     */
    public function listByUserId(int $userId):JsonResponse
    {
        try {
            $list = $this->saleService->listByUserId($userId);

            if ($list) {
                return response()->json(
                    [
                        'message' => 'Operation success',
                        'data' => $list
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (SaleException $e) {
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
