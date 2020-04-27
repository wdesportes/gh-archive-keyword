<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

final class SearchRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getSearchTerm(): string
    {
        return $this->query->get('searchTerm', '');
    }

    public function getSearchDate(): Carbon
    {
        return Carbon::createFromFormat('!Y-m-d', $this->query->get('searchDate'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array>
     */
    public function rules(): array
    {
        return [
            'searchTerm' => [
                'string',
                'sometimes',
            ],
            'searchDate' => [
                'string',
                'date:Y-m-d',
                'required',
            ]
        ];
    }
}
