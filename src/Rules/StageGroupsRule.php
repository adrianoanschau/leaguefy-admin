<?php

namespace Leaguefy\LeaguefyAdmin\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StageGroupsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_array($value)) {
            collect($value)->each(function ($item) use($fail) {
                if (!is_array($item)) $fail();
                else if(!isset($item['size'])) $fail();
                else if(is_null($item['size'])) $fail();
                else if(!is_integer($item['size'])) $fail();
            });
        } else if (!is_integer($value)) {
            $fail();
        }
    }
}
