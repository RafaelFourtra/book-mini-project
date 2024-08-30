<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->get();
            return response()->json(compact('data'));
        }

        return view('master.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => [
                    'required',
                    'lowercase',
                    'email',
                    'unique:' . User::class
                ],
                'password' => ['required'],
                'name' => ['required'],
                'role' => ['required']
            ], [
                'email.lowercase' => 'Email must be in lowercase letters only.',
                'email.email' => 'Invalid email format.',
                'email.unique' => 'This email is already in use.',
                'email.required' => 'The Email field is required.',
                'password.required' => 'The Password field is required.',
                'name.required' => 'The Name field is required.',
                'role.required' => 'The Role field is required.',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Store Master User - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Validasi Error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Store Master User - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::with('roles')->where('id', $id)->first();
        return view('master.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'email' => [
                    'required',
                    'lowercase',
                    'email',
                    Rule::unique('users')->ignore($id),
                ],
                'name' => ['required']
            ], [
                'email.lowercase' => 'Email must be in lowercase letters only.',
                'email.email' => 'Invalid email format.',
                'email.unique' => 'This email is already in use.',
                'email.required' => 'The Email field is required.',
                'name.required' => 'The Name field is required.',
            ]);

            $user = User::findOrFail($id);
            $user->update([
                'email' => $request->email,
                'name' => $request->name,
            ]);
            $roles = $user->roles->first();

            if ($roles) {
                if ($roles->name != $request->role) {
                    $user->removeRole($roles);
                    $user->assignRole($request->role);
                }
            } else {
                $user->assignRole($request->role);
            }

            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Update Master User - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Validasi Error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update Master User - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Delete Master User - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }
}
