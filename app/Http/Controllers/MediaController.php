<?php

namespace App\Http\Controllers;

use App\Actions\StoreMedialAction;
use App\Http\Requests\StoreMediaRequest;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function store(StoreMediaRequest $request, StoreMedialAction $storeMedialAction): JsonResponse
    {
        $path = $storeMedialAction->execute($request->file('image'));

        return response()->json(['name' => $path]);
    }
}
