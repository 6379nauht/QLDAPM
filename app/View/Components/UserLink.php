<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserLink extends Component
{
    public $user;

    public function __construct($user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    public function render()
    {
        return view('components.user-link');
    }
}
