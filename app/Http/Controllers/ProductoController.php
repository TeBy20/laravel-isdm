<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:lista_productos')->only('index');
    }

    public function index()
    {
        $productos = Producto::where('vendedor_id', auth()->user()->id)
            ->latest()
            ->get();
        return view('panel.vendedor.lista_productos.index', compact('productos'));
    }

    public function create()
    {
        $producto = new Producto();
        $categorias = Categoria::all();
        return view('panel.vendedor.lista_productos.create', compact('producto', 'categorias'));
    }

    protected $messages = [
        'nombre.required' => 'El campo nombre es obligatorio.',
        'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
        'nombre.max' => 'El campo nombre no debe tener más de :max caracteres.',
        'descripcion.required' => 'El campo descripción es obligatorio.',
        'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
        'descripcion.max' => 'El campo descripción no debe tener más de :max caracteres.',
        'precio.required' => 'El campo precio es obligatorio.',
        'precio.numeric' => 'El campo precio debe ser un número.',
        'precio.regex' => 'El campo precio debe ser un número válido con hasta dos decimales.',
        'categoria_id.required' => 'El campo categoría es obligatorio.',
        'categoria_id.exists' => 'La categoría seleccionada no es válida.',
        'imagen.image' => 'El archivo adjunto debe ser una imagen.',
        'imagen.mimes' => 'El archivo adjunto debe ser de tipo jpeg, png, jpg o gif.',
        'imagen.max' => 'El archivo adjunto no debe superar :max kilobytes.',
    ];

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:250',
            'precio' => ['required', 'regex:/^(\d{1,13}|\d{1,13}\.\d{1,2}|\d{1,13},\d{1,2})$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $this->messages);


        $producto = new Producto();
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->categoria_id = $request->input('categoria_id');
        $producto->vendedor_id = auth()->user()->id;

        if ($request->hasFile('imagen')) {
            $image_url = $request->file('imagen')->store('public/producto');
            $producto->imagen = asset(str_replace('public', 'storage', $image_url));
        } else {
            $producto->imagen = '';
        }

        $producto->save();

        return redirect()
            ->route('producto.index')
            ->with('alert', 'Producto "' . $producto->nombre . '" agregado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return view('panel.vendedor.lista_productos.show', compact('producto'));

    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('panel.vendedor.lista_productos.edit', compact('producto', 'categorias'));

    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:250',
            'precio' => ['required', 'regex:/^(\d{1,13}|\d{1,13}\.\d{1,2}|\d{1,13},\d{1,2})$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $this->messages);

        

        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->categoria_id = $request->input('categoria_id');

        if ($request->hasFile('imagen')) {
            $image_url = $request->file('imagen')->store('public/producto');
            $producto->imagen = asset(str_replace('public', 'storage', $image_url));
        }

        $producto->update();

        return redirect()
            ->route('producto.index')
            ->with('alert', 'Producto "' . $producto->nombre . '" actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('producto.index')
            ->with('alert', 'Producto eliminado exitosamente.');
    }
}

