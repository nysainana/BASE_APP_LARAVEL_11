<?php

namespace App\Traits;

trait EnumWithLabel
{

    protected function labels(): array
    {
        return [];
    }

    public function label()
    {
        return $this->labels()[$this->value] ?? null;
    }

    public static function toSelectable()
    {
        return collect(static::cases())
            ->map(fn($d) => ['label' => $d->label(), 'value' => $d->value]);
    }

}
