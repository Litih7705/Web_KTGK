<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class LaptopLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public $categories;
 
    public function __construct()
    {
        try {
            $this->categories = DB::table("danh_muc_laptop")->get();
        } catch (\Throwable $e) {
            // Keep page rendering even if category table is not ready.
            $this->categories = collect();
            Log::warning('Cannot load categories for laptop layout', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.laptop-layout');
    }
}
