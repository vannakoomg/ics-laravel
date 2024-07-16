<?php

namespace App\Http\Requests;

use App\Timetable;
use App\Rules\LessonTimeAvailabilityRule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreTimetableRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'class_id'   => [
                'required',
                'integer'],
            'start_time' => [
                'required',
                new LessonTimeAvailabilityRule(),
                'date_format:' . config('panel.lesson_time_format')],
            'end_time'   => [
                'required',
                'after:start_time',
                'date_format:' . config('panel.lesson_time_format')],
        ];
    }
}
