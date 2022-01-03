<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name' => 'bail|required|string|max:50',
            'location' => 'bail|required|string|max:255',
            'detail' => 'bail|required|string|max:1000',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'start_time' => 'required',
            'end_time' => 'bail|required|after:start_time',
            'instructor' => 'required',
//            'talents' => 'required',
            'max_score' => 'required|numeric|between:1,100'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'コース名が入力されていません。',
            'location.required' => '場所が入力されていません。',
            'detail.required' => 'コース詳細が入力されていません。',
            'start_date.required' => '開始日が入力されていません。',
            'end_date.required' => '終了日が入力されていません。',
            'start_time.required' => '開始時間が入力されていません。',
            'end_time.required' => '終了時間が入力されていません。',
            'instructor.required' => '担当者が選択されていません。',
//            'talents.required' => 'タレントが選択されていません。',
            'max_score.required' => '成績満点が入力されていません。',
            'end_date.after' => '終了日は開始日より後の日付である必要があります。',
            'end_time.after' => '終了時間は開始日より後の日付である必要があります。'
        ];
    }
}
