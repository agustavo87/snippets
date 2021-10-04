<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $response = "<h1> Respuesta </h1> \n";
        $relPath = $request->input('c', '');
        $base = resource_path('html');
        $fullPath =  realpath($base . '/' . $relPath);
        // dd($relPath, $base, $fullPath);
        if (strlen($fullPath) > strlen($base)) {
            $relPath = str_replace($base . '\\', '', $fullPath);
        } else {
            $relPath = '';
        }
        $view = str_contains($fullPath, '.html') ? $fullPath : $fullPath . '.html';
        if (file_exists($view)) {
            $html = file_get_contents($view);
            // dd('file exists', $html);
            return view('html.render', [
                'html' => file_get_contents($view),
                'path' => dirname($relPath),
                'file' => basename($view, '.html')
            ]);
        }
        if (is_dir($fullPath)) {
            $files = scandir($fullPath);
            array_shift($files);
            $links =   array_map(function ($value) use ($relPath) {
                return $relPath . '/' . $value;
            }, $files);

            $response .= "<ul>\n";
            foreach ($links as $link) {
                $response .= "<li>";
                $response .= "<a href='/components?c={$link}'> $link </a>";
                $response .= "</li>\n";
            }
            $response .= "</ul>\n";
            return $response;
        }
        return 'directorio inválido';
    }
}
