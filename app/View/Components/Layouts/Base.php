<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Base extends Component
{
    public $title = 'Own the UI';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Own The UI')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //
        return view('components.layouts.base');
    }
}
