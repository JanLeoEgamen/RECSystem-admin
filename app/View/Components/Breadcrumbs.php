<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public function render()
    {
        $segments = request()->segments();

        return view('components.breadcrumbs', [
            'segments' => $segments,
        ]);
    }
}
