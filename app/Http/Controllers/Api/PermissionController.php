<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function getUserPermissions()
    {
        try {
            $permissions = [];
            foreach(Auth::user()->roles as $role)
            {
                $rolePermissions = $role->permissions()->pluck('name')->toArray();
                $permissions = array_merge($permissions,$rolePermissions);
            }
            return response([
                "permissions" => array_unique($permissions),
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
