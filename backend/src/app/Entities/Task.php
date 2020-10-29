<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Task implements Arrayable
{
    protected $id;
    protected $description;
    protected $weightPct;
    protected $performedInJobExperience;

    public function toArray() {

        $output = [];

        foreach ( get_class_vars(get_class($this)) as $propName => $propDefaultValue ) {
            $output[ $propName ] = $this->{$propName};
        }

        return $output;

    }
}