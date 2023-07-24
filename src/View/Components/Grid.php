<?php

namespace Leaguefy\LeaguefyAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{
    /**
     * Create a new component Grid.
     *
     * @param string $name
     * @param mixed $data
     * @param array<string|mixed> $columns
     */
    public function __construct(
        public string $name,
        public mixed $data,
        public mixed $columns,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $this->columns = collect($this->columns)->map(function ($column) {
            $column = is_string($column) ? ['column' => $column] : $column;

            return [
                'label' => $column['label'] ?? ucfirst($column['column'] ?? ''),
                'column' => $column['column'] ?? null,
                'classes' => $column['classes'] ?? '',
                'avatar' => $column['avatar'] ?? null,
                'subtitle' => $column['subtitle'] ?? null,
                'link_route' => $column['link_route'] ?? null,
                'link_icon' => $column['link_icon'] ?? null,
            ];
        })->toArray();

        return view('leaguefy-admin::components.grid', [
            'name' => $this->name,
            'columns' => $this->columns,
            'data' => $this->data,
        ]);
    }
}
