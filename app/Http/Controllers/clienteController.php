<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaResquest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Documento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\Cliente;

class clienteController extends Controller
{

    public function index()
    {
        $clientes = Cliente::with('persona.documento')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $documentos = Documento::all();
        return view('clientes.create', compact('documentos'));
    }

    public function store(StorePersonaResquest $request)
    {
        try {
            DB::beginTransaction();

            $persona = Persona::create($request->validated());
            $persona->cliente()->create([
                'persona_id' => $persona->id
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return redirect()->route('clientes.index')->with('success','Cliente registrada');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Cliente $cliente)
    {
        $cliente->load('persona.documento');
        $documentos = Documento::all();
        return view('clientes.edit', compact('cliente','documentos'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        try {
            DB::beginTransaction();

            Persona::where('id', $cliente->persona->id)->update($request->validated());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('clientes.index')->with('success','Cliente actualizado');
    }

    public function destroy(string $id)
    {
        $message = '';
        $persona = Persona::find($id);
        if($persona->estado == 1){
            Persona::where('id', $persona->id)->update([
                'estado'=>0
            ]);
            $message = 'Persona eliminado';
        }else{
            Persona::where('id', $persona->id)->update([
                'estado'=>1
            ]);
            $message = 'Persona restaurado';
        }

        return redirect()->route('clientes.index')->with('success', $message);
    }
}
