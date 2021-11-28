<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;

class PathController extends Controller
{
    public function configure(Request $request)
    {
        /** @var \App\Model\Path */
        $path = Path::firstOrCreate([
            'path' => $request->input('path')
        ]);
        foreach ($request->input('data') as $name => $value) {
            $path->attributes()->updateOrCreate(
                ['path_id' => $path->id, 'name' => $name],
                ['value'    => $value]
            );
        }
        $request->session()->flash('status', 'Configuración establecida exitosamente!');
        return back();
    }
}
