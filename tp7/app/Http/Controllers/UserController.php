<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index, store, create, update, edit, destroy, show

    /**
     *esta funcion redirige al login
     */
    public function login()
    {
        return view('users.login');
    }


    /**
     *esta funcion hace la autenticación
     */
    public function autenticar(Request $request)
    {
        $request->validate([
            'user' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['user' => $request->user, 'password' => $request->password])) { //si las credenciales están bien
            $request->session()->regenerate();
            return redirect()->intended(route('peliculas.index')); //puedo tener estos dos return acá?
        }
        return back()->withErrors([ //si las credenciales están mal
            'user' => 'Las credenciales proporcionadas no son válidas.',
        ])->onlyInput('user');
    }


    /**
     *esta funcion hace el logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


    public function create(): View
    {
        return view('users.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user' => ['required', 'string', 'min:5', 'max:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:12'],
        ]);

        $usuario = new User();
        $usuario->user = $request->input('user');

        $usuario->password = Hash::make($request->input('password'));  //esto es para q no me de problema con bcrypt

        $usuario->save();

        return redirect()->route('peliculas.index')
            ->with('exitoUsuario', 'Usuario creado con éxito!');
    }
}
