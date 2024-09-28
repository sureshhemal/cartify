<?php

namespace App\Http\Controllers;

use Domain\RolesAndPermissions\Actions\GetRolesAction;
use Illuminate\Http\JsonResponse;

class RolesController extends Controller
{
    public function index(GetRolesAction $getRolesAction): JsonResponse
    {
        return response()->json($getRolesAction->execute());
    }
}
