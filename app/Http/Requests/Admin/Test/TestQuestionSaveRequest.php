<?php

namespace App\Http\Requests\Admin\Test;

use Illuminate\Foundation\Http\FormRequest;

class TestQuestionSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'text' => 'required',
//            'subject_id' => 'required',
//            'correct_answer_number' => 'required',
//            'preparation_ids' => 'required',
//            'answers' => 'required',
//            'answers.*.text' => 'required',
        ];
    }
}
