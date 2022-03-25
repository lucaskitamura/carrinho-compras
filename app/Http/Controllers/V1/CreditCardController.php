<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\ValidateCardException;
use App\Http\Controllers\Controller;
use App\Services\V1\CreditCard\CreditCardService;
use App\Http\Requests\CreditCard\CreditCardStoreRequest;
use App\Http\Requests\CreditCard\CreditCardUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;

class CreditCardController extends Controller
{
    private $creditCardService;

    public function __construct(CreditCardService $creditCardService)
    {
        $this->creditCardService = $creditCardService;
    }

    /**
     * @param CreditCardStoreRequest $request
     * @return jsonResponse
     */
    public function store(CreditCardStoreRequest $request):JsonResponse
    {
        try {
            $creditCardData = $request->validated();

            if ($this->creditCardService->store($creditCardData)) {
                return response()->json(
                    [
                        'message' => 'Operation success'
                    ],
                    Response::HTTP_CREATED
                );
            }
        } catch (ValidateCardException $e) {
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
     * @param CreditCardUpdateRequest $request
     * @return jsonResponse
     */
    public function update(CreditCardUpdateRequest $request, int $creditCardId):JsonResponse
    {
        try {
            $creditCardData = $request->validated();

            if ($this->creditCardService->update($creditCardId, $creditCardData)) {
                return response()->json(
                    [
                        'message' => 'Operation success'
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (ValidateCardException $e) {
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
     * @param int $creditCardId
     * @return jsonResponse
     */
    public function delete(int $creditCardId):JsonResponse
    {
        try {
            if ($this->creditCardService->delete($creditCardId)) {
                return response()->json(
                    [
                        'message' => 'Operation success'
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unexpected error, try later'
           ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
