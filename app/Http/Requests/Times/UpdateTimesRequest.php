<?php

namespace App\Http\Requests\Times;

use App\Rules\NotContainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTimesRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'project_id' => ['required'],
            'employee_id' => ['required'],
            'work_date' => ['required','date_format:Y/m/d'],
            'work_time' => ['required','numeric'],
        ];
    }

    public function attributes($params = [])
    {
        return [
            'project_id' => '案件',
            'employee_id' => '社員',
            'work_date' => '作業日付',
            'work_time' => '作業時間',
        ];
    }

}
