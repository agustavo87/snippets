<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Arete\Snippets\SnippetManager;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    protected SnippetManager $snippets;

    public function __construct()
    {
        $this->snippets = new SnippetManager(resource_path('html'));
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->snippets->setPath($request->input('path', ''));

        if ($this->snippets->getSnippetPath()) {
            $data = $this->snippets->getData();
            if ($request->input('html') == 'true') {
                return view('html.render', $data);
            }
            $path = Path::firstWhere('path', $data['relativePath']);
            if ($path) {
                $attributes = $path->attributes->pluck('value', 'name')->all();
            } else {
                $attributes = Path::DEFAULT_ATTRIBUTES;
            }
            $data['attributes'] = $attributes;
            return view('html.present', $data);
        } elseif ($this->snippets->isDir()) {
            $href = [];
            foreach ($this->snippets->links() as $link) {
                $href[$link] = route('components', ['path' => $link]);
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
