<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(User $user = null){
        return view('user.create', compact('user'));
    }

    public function index(){
        $users = User::Paginate(10);
        return view('user.index', compact('users'));
    }

    public function store(UserRequest $request, User $user = null){
        $data = $request->validated();
        // dd($data['name']);

        if($user){
            if($data['password']){
                $user->update([
                    'name'      => $data['name'],
                    'email'     => $data['email'],
                    'password'  => $data['password'],
                    'is_admin'  => $data['is_admin'],
                ]);
            }else{
            $user->update([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'is_admin'  => $data['is_admin'],
            ]);
            }

            $notification = array(
                'message' =>    'Utilizator modificat cu succes!',
                'alert-type'    => 'success',
            );

        }else{
            User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'rolis_admine'  => $data['is_admin'],
            ]);

            $notification = array(
                'message' =>    'Utilizator inregistrat cu succes!',
                'alert-type'    => 'success',
            );
        }

        return redirect()->route('users.index')->with($notification);
    }

    public function delete(User $user){

        $user->delete();

        $notification = array(
            'message' =>    'Utilizator sters cu succes!',
            'alert-type'    => 'success',
        );

        return redirect()->route('users.index')->with($notification);
    }

    public function myProfile(){
        $user = Auth()->user();
        return view('user.myProfile', compact('user'));
    }

    public function change(Request $request, User $user){

        $request->validate([
            'name'      => ['required'],
            'email'     => ['required'],
            'is_admin'  => ['required'],
        ]);

        if($request->password){
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'is_admin'  => $request->is_admin,
            ]);
        }else{
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'is_admin'  => $request->is_admin,
            ]);
            }
        
            $notification = array(
                'message' =>    'Modificari inregistrate cu succes!',
                'alert-type'    => 'success',
            );

            return redirect()->back()->with($notification);
    }
}
