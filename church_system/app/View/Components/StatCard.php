<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatCard extends Component
{
    public $icon;
    public $color;
    public $title;
    public $value;
    public $subtitle;

    public function __construct(
        string $icon,
        string $color = 'amber',
        string $title,
        $value,
        ?string $subtitle = null
    ) {
        $this->icon     = $icon;
        $this->color    = $color;
        $this->title    = $title;
        $this->value    = $value;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('components.stat-card');
    }
}
