<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSesionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "start_time" => ["required", "date"],
            "end_time" => ["required", "date", "after:start_time"],
            "status" => ["required", "in:scheduled,completed,canceled"],
            "patient_id" => ["required", "exists:patients,id"],
            "user_id" => ["required", "exists:users,id"],
        ];
    }
}
