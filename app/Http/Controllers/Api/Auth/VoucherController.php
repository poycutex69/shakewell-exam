<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherResource;
use App\Http\Resources\VoucherResourceCollection;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
use App\Services\VoucherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VoucherController extends BaseController
{
    public function __construct(
        protected VoucherRepository $repo, 
        protected VoucherService $service
    ) {
        
    }

    public function index(): ResourceCollection
    {
        $user = Auth::user();
        $vouchers = $user->vouchers()->get();

        return new VoucherResourceCollection($vouchers);
    }

    public function show($id, Request $request): JsonResponse
    {
        if($model = $this->repo->find($id)) {
            if (Gate::allows('view-voucher', $model)) {
                $data = (new VoucherResource($model))->toArray($request);
                return $this->jsonResponse($data);
            } else {
                return $this->httpResponseMessage('Unauthorized', [], 403);
            }
        }

        return $this->notFoundErrorResponse('Voucher');
    }

    public function store(Request $request): JsonResponse
    {
        if($this->repo->countVouchers() < 10) {
            $voucher = $this->service->create(auth()->user());
            $data = (new VoucherResource($voucher))->toArray($request);
            return $this->jsonResponse($data);
        } else {
            return $this->httpResponseMessage('Voucher maximum limit reached', [], 422);
        }

        
    }

    public function destroy($id): JsonResponse
    {
        if($model = $this->repo->find($id)) {
            if (Gate::allows('delete-voucher', $model)) {
                $this->service->delete($model);
                return $this->successResponse('Success');
            } else {
                return $this->httpResponseMessage('Unauthorized', [], 403);
            }
        }

        return $this->notFoundErrorResponse('Voucher');

        
    }
}
