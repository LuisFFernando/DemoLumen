<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function Index(Request $request)
    {
        //validacion para que no se pueda acceder  desde el navegador
        if ($request->isJson()) {
            $usuario = User::all();
            return response()->json($usuario, 200);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : 'Application/json'"], 403);
    }

    public function create(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'api_token' => str_random(60)
            ]);
            return response()->json([], 201);
        } return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }

    public function findId(Request $request, $id)
    {
        if ($request->isJson()) {
            $user = User::find($id);
            return response()->json($user, 200);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }

    public function update($id, Request $request)
    {
        if ($request->isJson()) {
            $user = User::findOrFail($id);
           $user->update($request->all());
            return response()->json([], 204);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }

    public function delete($id, Request $request)
    {
        if ($request->isJson()) {
            User::findOrFail($id)->delete();
            return response([], 204);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }

    function getToken(Request $request)
    {
        if ($request->isJson()) {
        try {
            $data = $request->json()->all();
            $user = User::where('username', $data['username'])->where('password',$data['password'])->first();

            if ($user==true) {
                return response()->json($user, 200);
            } else {
                return response()->json(['error' => 'error in user or password'], 401);
            }

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'no content'], 406);
        }
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);

    }
}
