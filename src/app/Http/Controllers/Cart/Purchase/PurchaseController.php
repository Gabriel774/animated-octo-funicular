<?php

namespace App\Http\Controllers\Cart\Purchase;

use App\Http\Controllers\Cart\Purchase\PurchaseRequest;
use App\Http\Controllers\Controller;
use App\UseCases\Cart\CalculateCartSubTotal;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    public function __invoke(PurchaseRequest $request): JsonResponse
    {
        $subTotal = $this->getSubTotal($request);

        // payment logic, store purchase data in database etc.

        return response()->json(compact('subTotal'));
    }

    protected function getSubTotal(PurchaseRequest $request): float
    {
        return CalculateCartSubTotal::handle(
            $request->getCartItems(),
            $request->getPaymentMethod(),
            $request->input('installments')
        );
    }

}
