<?php

namespace Sbing\Nova\Images\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'storagePath' => 'nullable|string|max:100',
            'disk' => ['nullable', Rule::in(array_keys(config('filesystems.disks')))],
        ];
    }
}
