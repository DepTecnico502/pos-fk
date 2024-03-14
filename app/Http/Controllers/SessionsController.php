<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store() {
        if(auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'El correo o la contraseña es incorrecto, por favor prueba de nuevo.',
            ]);
        }else {
            if(auth()->user()->id_rol == 1) {
                return redirect()->route('configuracion.usuarios.index');
            }else if(auth()->user()->id_rol == 2){
                return redirect()->route('clientes.index');
            }else if(auth()->user()->id_rol == 3){
                return redirect()->route('ventas.index');
            }
            else {
                return redirect()->to('/');
            }
        }
    }

    public function destroy() {
        auth()->logout();
        
        return redirect()->to('/');
    }
}
