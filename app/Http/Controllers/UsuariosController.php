<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index(){
        $usuarios = User::all();
        return view('administracion.usuarios.index', compact('usuarios'));
    }

    public function create(){
        $rol = Rol::all();
        $cajas = Caja::all();

        return view('administracion.usuarios.crear', [
            'rol' => $rol,
            'cajas' => $cajas
        ]);
    }

    public function store(Request $request){
        $usuario = new User();

        $usuario->name = $request->nombre;
        $usuario->user = $request->user;
        $usuario->email = $request->email;
        $usuario->id_rol = $request->id_rol;
        $usuario->caja_id = $request->caja_id;
        $usuario->active = $request->activo;
        $usuario->password = Hash::make($request->password);
        try {
            $usuario->save();
            return redirect()->route('configuracion.usuarios.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Usuario creado correctamente',
                'tipo' => 'alert-success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('configuracion.usuarios.index')->with([
                'error' => 'Error',
                'mensaje' => 'El usuario no pudo ser creado' . $e,
                'tipo' => 'alert-danger'
            ]);
        }
    }

    public function show($id){
        $usuario = User::find($id);
        $rol = Rol::all();
        $cajas = Caja::all();
        
        return view('administracion.usuarios.editar', [
            'usuario' => $usuario,
            'rol' => $rol,
            'cajas' => $cajas
        ]);
    }

    public function update(Request $request, User $usuario){
        $usuario->name = $request->nombre;
        $usuario->user = $request->user;
        $usuario->email = $request->email;
        $usuario->id_rol = $request->id_rol;
        $usuario->caja_id = $request->caja_id;
        $usuario->active = $request->activo;
        try {
            $usuario->save();
            return redirect()->route('configuracion.usuarios.index')->with([
                'error' => 'Exito',
                'mensaje' => 'Usuario modificado correctamente',
                'tipo' => 'alert-primary'
            ]);
        } catch (\Exception $e) {
            $rol = Rol::all();
            return view('administracion.usuarios.editar', compact(['usuario','rol']));
        }
    }
}
