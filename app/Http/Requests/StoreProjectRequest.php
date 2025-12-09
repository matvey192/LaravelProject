<?php

namespace App\Http\Requests;

class StoreProjectRequest extends ProjectRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name'     => 'required|string|max:255',
            'url'      => ['required', 'url', 'regex:/^https?:\/\//i'],
            'platform' => 'required|in:' . implode(',', \App\Enums\PlatformEnum::getValues()),
            'status'   => 'required|in:' . implode(',', \App\Enums\ProjectStatusEnum::getValues()),
        ]);
    }
}
