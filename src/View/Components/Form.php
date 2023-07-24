<?php

namespace Leaguefy\LeaguefyAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component Form.
     *
     * @param string $name
     * @param array<string|mixed> $fields
     * @param int|string|null $id
     * @param mixed $data
     */
    public function __construct(
        public string $name,
        public array $fields,
        public int|string|null $id = null,
        public mixed $data = null,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $this->fields = collect($this->fields)->map(function ($field) {
            $field = is_string($field) ? ['column' => $field] : $field;

            return [
                'label' => $field['label'] ?? ucfirst($field['column']),
                'column' => $field['column'],
                'type' => $field['type'] ?? 'text',
                'options' => $field['options'] ?? null,
                'disabled' => $field['disabled'] ?? false,
            ];
        })->toArray();

        return view('leaguefy-admin::components.form', [
            'id' => $this->id,
            'name' => $this->name,
            'fields' => $this->fields,
            'data' => $this->data,
        ]);
    }
}
