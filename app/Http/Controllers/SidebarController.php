<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoleUser;
use App\Empresa;
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{

    public function dashboard(Request $request) {

        // Solo usuairos con role todos los permisos
        $request->user()->authorizeRoles(['user', 'admin']);

        $list =  RoleUser::query('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->join('roles',  'role_user.role_id',  '=', 'roles.id')
            ->select('role_user.*',
                     'users.name',
                     'users.email',
                     'roles.description'
                    )
            ->get();

        return view('home',
            [
                'role' => $request,
                'lists' => $list
            ]
        );

    }

    public function profile(Request $request) {

        $id = Auth::id();

        $empresa = Empresa::latest()->get();
        $user = RoleUser::query('role_user')
        ->join('users', 'role_user.user_id', '=', 'users.id')
        ->join('roles',  'role_user.role_id',  '=', 'roles.id')
        ->select('role_user.*',
                            'users.name',
                            'users.email',
                            'users.rfc',
                            'roles.description'
                )->where('user_id',$id)
        ->get();

        // Solo usuairos con role todos los permisos
        $request->user()->authorizeRoles(['user', 'admin']);
        return view('layouts.sidebar.perfil',[
            'user'    => $user,
            'empresa' => $empresa
        ]);
    }

    public function empresa(Request $request) {

        $empresa = Empresa::latest()->get();

        $users = RoleUser::query('role_user')
        ->join('users', 'role_user.user_id', '=', 'users.id')
        ->join('roles',  'role_user.role_id',  '=', 'roles.id')
        ->select('role_user.*',
                            'users.name',
                            'roles.description'
                )
        ->get();

        // Solo usuairos con role todos los permisos
        $request->user()->authorizeRoles(['user', 'admin']);
        return view('layouts.sidebar.empresa', [
            'users' => $users,
            'empresa' => $empresa
        ]);
    }

}
