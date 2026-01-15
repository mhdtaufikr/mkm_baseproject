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

                ->addColumn('action', function ($u) {
                    return '
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update' . $u->id . '">
                    <i class="fas fa-user-edit"></i>
                </button>
                ' . (
                        $u->is_active
                        ? '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-revoke' . $u->id . '">
                                <i class="fas fa-user-lock"></i>
                           </button>'
                        : '<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-access' . $u->id . '">
                                <i class="fas fa-user-check"></i>
                           </button>'
                    );
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        // normal page load
        $roles       = Dropdown::where('category', 'Role')->pluck('name_value');
        $departments = Dropdown::where('category', 'Dept')->pluck('name_value');
        $jobTitles   = Dropdown::where('category', 'Job Title')->pluck('name_value');
        $dropdown    = Dropdown::where('category', 'Role')->get();
        $dept        = Dropdown::where('category', 'Dept')->get();
        $user        = User::get();

        return view('users.index', compact(
            'roles',
            'departments',
            'jobTitles',
            'dropdown',
            'dept',
            'user'
        ));
    }



    public function store(Request $request)
    {
        // 1) Validate input
        $request->validate([
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username',
            'email'      => 'required|email|max:255|unique:users,email',
            'role'       => 'nullable|string|max:255',
            'job_title'  => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'img'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2) Handle image upload first (outside DB tx so file is ready)
        $imgPath = null;
        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('assets/img/users');
            $file->move($destPath, $fileName);
            $imgPath  = 'assets/img/users/' . $fileName;
        }

        // set up defaults
        $defaultPassword = 'Password.1';
        $loginUrl        = route('login');

        try {
            DB::beginTransaction();

            // 3) Create user (dummy random password for now)
            $user = User::create([
                'name'      => $request->input('name'),
                'username'  => $request->input('username'),
                'email'     => $request->input('email'),
                'password'  => bcrypt(Str::random(16)),
                'img'       => $imgPath,
                'is_active' => 1,
                'supervisor_id' => $request->input('supervisor'),
                'role' => 'PERSON',
            ]);

            // 4) Pivot in job_title & department
            // $user->positions()->create([
            //     'job_title'  => $request->input('job_title'),
            //     'department' => $request->input('department'),
            // ]);

            // 5) Override to default password
            $user->update([
                'password' => bcrypt($defaultPassword),
            ]);

            // 6) Send the email (if this fails it'll throw)
            // Mail::to($user->email)
            //     ->cc([
            //         'muhammad.taufik@ptmkm.co.id',
            //         'Aditia@ptmkm.co.id',
            //         'bayu@ptmkm.co.id',
            //         'budi.prasetio@ptmkm.co.id',
            //     ])
            //     ->send(new UserCreated($user, $defaultPassword, $loginUrl));

            DB::commit();

            return redirect()->back()
                ->with('success', 'User created and notification email sent!');
        } catch (\Exception $e) {
            DB::rollBack();

            // optionally delete the uploaded file if it exists
            if ($imgPath && file_exists(public_path($imgPath))) {
                @unlink(public_path($imgPath));
            }

            // re-throw or return with error
            return redirect()->back()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }


    public function revoke($id)
    {
        $revoke = User::where('id', $id)
            ->update([
                'is_active' => '0',
            ]);

        return redirect('/user')->with('status', 'Success Revoke User');
    }
    public function access($id)
    {
        $access = User::where('id', $id)
            ->update([
                'is_active' => '1',
            ]);
        return redirect('/user')->with('status', 'Success Give User Access');
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
        $user->role = $request->input('role');
        $user->email = $request->input('email');
        $user->supervisor_id = $request->input('supervisor');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password')); // Encrypt the password
        }
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }
}
