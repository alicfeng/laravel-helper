<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace App\Http\Requests;

use AlicFeng\Helper\Code\HttpCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class FormRequest extends BaseFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $structure = config('helper.package.structure');

        throw (new HttpResponseException(response()->json([$structure['code']    => HttpCode::HTTP_UNPROCESSABLE_ENTITY, $structure['message'] => 'entity unprocessable', $structure['data']    => $validator->errors()], HttpCode::HTTP_UNPROCESSABLE_ENTITY)));
    }
}
