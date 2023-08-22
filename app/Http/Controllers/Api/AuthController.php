<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CredentialsMismatchException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw new CredentialsMismatchException();
            }

            $token = $user->createToken('my-app-token')->plainTextToken;

            $data = [];
            $data['id'] = $user->id;
            $data['email'] = $user->email;
            $data['name'] = $user->name;
            $roles = $user->getRoleNames();
            $data['role'] = $roles->first();
            $data['token'] = $token;
            $data['image'] = $user->image;
            $this->storeActivity($user);

            return response()->json(['message' => 'Login Success', 'status' => 200, 'data' => $data]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = $e->validator->errors();

            return response()->json([
                'errors' => $errors,
            ], 422);
        } catch (CredentialsMismatchException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function storeActivity($user)
    {
        $data = [
            'user_id' => $user->id,
            'model_id' => $user->id,
            'model_name' => 'User',
            'activity_type' => 'Login',
            'activity' => 'Login successfully!',
        ];

        ActivityLog::create($data);
    }
}
