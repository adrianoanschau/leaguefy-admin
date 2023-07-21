<?php

namespace Leaguefy\LeaguefyAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $columns,
        public mixed $data,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('leaguefy-admin::components.grid', [
            'columns' => $this->columns,
            'data' => $this->data,
        ]);
    }
}
