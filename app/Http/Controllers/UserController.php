<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        // return $request->user();
        return (new UserResource($request->user())
        )->additional([
            'meta' => [
                'is_admin' => $request->user()->hasRole('admin'),
                'is_moderator' => $request->user()->hasRole('moderator'),
            ]
        ]);
    }
}
