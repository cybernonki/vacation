<?php

namespace App\Http\Requests\Project;

use App\Rules\NotContainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','max:200'],
            'usecount' => ['required','numeric'],
            'memo' => ['nullable','max:200'],
            'sort' => ['required','numeric'],
        ];
    }

    public function attributes($params = [])
    {
        return [
            'name' => '名前',
            'usecount' => '休暇カウント',
            'memo' => 'メモ',
            'sort' => 'ソート',
        ];
    }

}
