<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertLoader extends Component
{
    public array $alerts;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $success = '',
        string $error = '',
        string $info = ''
    ) {
        $this->alerts = compact('success', 'error', 'info');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert-loader');
    }
}
