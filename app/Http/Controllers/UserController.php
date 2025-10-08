<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'phone', 'role', 'is_active')->paginate(10);

        $roles = User::getRoleOptions();

        foreach ($users as $user) {
            $user->can_delete = $user->orders()->count() == 0;
        }

        return view('user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::getRoleOptions();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users,email',
                'phone' => 'required|string|max:20|regex:/^[0-9]+$/|unique:users,phone',
                'password' => 'required|string|min:5|max:255',
                'role' => 'required',
                'address' => 'required|string',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = User::getRoleOptions();

        return view('user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data =
            [
                'name' => 'required|max:255',
                'role' => 'required',
                'address' => 'required',
            ];

        if ($request->email != $user->email) {
            $data['email'] = 'required|email:dns|unique:users';
        } else {
            $data['email'] = 'required|email:dns';
        }

        if ($request->phone != $user->phone) {
            $data['phone'] = 'required|max:13|regex:/^[0-9]+$/|unique:users';
        } else {
            $data['phone'] = 'required|max:13|regex:/^[0-9]+$/';
        }

        $validatedData = $request->validate($data);

        $validatedData['is_active'] = $request->boolean('is_active');

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $user->update($validatedData);

        return redirect()->route('user.index')->with('success', "Data user dengan nama {$user->name} berhasil di update.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->orders->count() !== 0) {
            return redirect()
                ->back()->with(
                    'error',
                    'Data user ini telah terhubung ke data order, tidak dapat dihapus.'
                );
        }

        $user->destroy($user->id);
        return redirect()
            ->route('user.index')
            ->with('success', 'Data user berhasil dihapus.');
    }
}
