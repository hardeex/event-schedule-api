<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can add authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'max_participants' => 'required|integer|min:1',
        ];
    }

    /**
     * Customize the response for failed validation.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422));
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide a name for the event.',
            'start_datetime.required' => 'Please specify the start date and time.',
            'start_datetime.after' => 'The start date must be in the future.',
            'end_datetime.required' => 'Please specify the end date and time.',
            'end_datetime.after' => 'The end date must be after the start date.',
            'max_participants.required' => 'Please specify the maximum number of participants.',
            'max_participants.integer' => 'Maximum participants must be a number.',
            'max_participants.min' => 'There must be at least one participant allowed.',
        ];
    }
}
