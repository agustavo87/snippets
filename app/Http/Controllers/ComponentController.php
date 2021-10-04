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
        $relPath = $request->input('c', '');
        $base = resource_path('html');
        $fullPath =  realpath($base . '/' . $relPath);
        if (strlen($fullPath) > strlen($base)) {
            $relPath = str_replace($base . '\\', '', $fullPath);
        } else {
            $relPath = '';
        }
        $view = str_contains($fullPath, '.html') ? $fullPath : $fullPath . '.html';
        if (file_exists($view)) {
            $data = [
                'c' => $relPath,
                'html' => file_get_contents($view),
                'path' => dirname($relPath),
                'file' => basename($view, '.html')
            ];
            if ($request->input('html') == 'true') {
                return view('html.render', $data);
            }
            return view('html.present', $data);
        }
        if (is_dir($fullPath)) {
            $files = scandir($fullPath);
            array_shift($files);
            $links =   array_map(function ($value) use ($relPath) {
                return $relPath . '/' . $value;
            }, $files);
            $href = [];
            foreach ($links as $link) {
                $href[$link] = route('components', ['c' => $link]);
            }
            return view('twcomponents.index', [
                'links' => $href
            ]);
        }
        return view('twcomponents.index', [
            'links' => []
        ]);
    }
}
