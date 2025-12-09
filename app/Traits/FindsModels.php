<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait FindsModels
{
    protected function findOrFailCustom(string $model, int $id)
    {
        $item = $model::find($id);

        if (!$item) {
            throw (new ModelNotFoundException)->setModel($model, [$id]);
        }

        return $item;
    }
}
