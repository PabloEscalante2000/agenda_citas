<?php

namespace App\Http\Requests;

use App\Models\Sesion;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateSesionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can("update", $this->route("sesion"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "start_time" => ["required", "date", "after:now"],
            "end_time" => ["required", "date", "after:start_time"],
            "status" => ["required", "in:scheduled,completed,canceled"],
            "patient_id" => ["required", "exists:patients,id"],
            "user_id" => ["required",
                Rule::exists("users","id")->where("role","t")
            , "exists:users,id"],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if($validator->errors()->isNotEmpty()) {
                    return;
                }

                $solapa = Sesion::overLapping(
                    $this->user_id,
                    $this->start_time,
                    $this->end_time
                )->exists();

                if($solapa) {
                    $validator->errors()->add(
                        "start_time",
                        "La sesión se solapa con otra sesión existente."
                    );
                }
            }
        ];
    }
}
