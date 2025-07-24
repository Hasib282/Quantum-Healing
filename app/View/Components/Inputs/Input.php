<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $id, $label, $name, $update, $small;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $label, $name, $update = false, $small = false)
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->update = $update;
        $this->small = $small;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.input');
    }
}
