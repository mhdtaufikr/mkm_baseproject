<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dropdown;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = User::select([
                'users.id',
                'users.username',
                'users.name',
                'users.email',
                'users.role',
                'users.last_login',
                'users.is_active',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()

                ->editColumn('last_login', function ($u) {
                    return $u->last_login
                        ? \Carbon\Carbon::parse($u->last_login)->format('d-m-Y H:i:s')
                        : 'Never';
                })

                ->addColumn('department', fn() => '-')
                ->addColumn('job_title', fn() => '-')

                ->addColumn('action', function ($user) {

                    $avatar = $user->avatar;

                    $editBtn = '
                        <button class="btn btn-sm btn-primary btn-edit-user"
                            data-id="' . $user->id . '"
                            data-name="' . $user->name . '"
                            data-username="' . $user->username . '"
                            data-email="' . $user->email . '">
                            <i class="fas fa-edit"></i>
                        </button>
                    ';

                    if ($user->is_active) {
                        $statusBtn = '
                            <button class="btn btn-sm btn-danger btn-revoke-user"
                                data-id="' . $user->id . '"
                                data-email="' . e($user->email) . '">
                                <i class="fas fa-ban"></i>
                            </button>
                        ';
                    } else {
                        $statusBtn = '
                        <button class="btn btn-sm btn-success btn-activate-user"
                            data-id="' . $user->id . '"
                            data-email="' . e($user->email) . '">
                            <i class="fas fa-user-check"></i>
                        </button>
                    ';
                    }

                    return $editBtn . $statusBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:45|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:45|unique:users,phone',
            'role'     => 'nullable|string|max:255',
            'plant'    => 'nullable|string|max:45',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'required|string|max:16|min:8',
        ]);

        DB::beginTransaction();

        try {
            $avatarPath = null;

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')
                    ->store('avatars', 'public');
            }

            $user = User::create([
                'name'       => $request->name,
                'username'   => $request->username,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'avatar'     => $avatarPath,

                'password'   => bcrypt($request->password),
                'role'       => $request->role ?? 'PERSON',
                'plant'      => $request->plant,

                'status'     => 'ACTIVE',
                'is_active'  => true,

                'login_counter' => 0,
                'password_changed_at' => null,
            ]);

            /*
        Mail::to($user->email)
            ->send(new UserCreated($user, $defaultPassword, route('login')));
        */

            DB::commit();

            return redirect()->back()
                ->with('success', 'User created successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }

            return redirect()->back()
                ->with('error', 'Failed to create user');
        }
    }


    public function revoke($id)
    {
        User::where('id', $id)->update([
            'is_active' => false,
            'status'    => 'SUSPENDED',
        ]);

        return response()->json(['ok' => true]);
    }

    public function activate($id)
    {
        User::where('id', $id)->update([
            'is_active' => true,
            'status'    => 'ACTIVE',
        ]);

        return response()->json(['ok' => true]);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|max:255' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $destinationPath = public_path('assets/img/users');
            $file->move($destinationPath, $fileName);
            $user->img = 'assets/img/users/' . $fileName;
        }

        // Update user fields
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password')); // Encrypt the password
        }
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }
}
