<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Breadcrumbs extends Component
{
    public $segments;
    
    public function __construct()
    {
        $this->segments = $this->processSegments();
    }
    
    protected function processSegments()
    {
        $segments = request()->segments();
        $processed = [];
        $currentRoute = Route::current();
        
        foreach ($segments as $index => $segment) {
            if (is_numeric($segment)) {
                continue;
            }
            
            if ($currentRoute && $currentRoute->hasParameter($segment)) {
                continue;
            }
            
            $processed[] = [
                'name' => $this->formatSegmentName($segment),
                'url' => url(implode('/', array_slice($segments, 0, $index + 1))),
                'is_last' => $index + 1 === count($segments)
            ];
        }
        
        return $processed;
    }
    
    protected function formatSegmentName($segment)
    {
        $name = str_replace(['-', '_'], ' ', $segment);
        return ucwords($name);
    }
    
    public function render()
    {
        return view('components.breadcrumbs');
    }
}

