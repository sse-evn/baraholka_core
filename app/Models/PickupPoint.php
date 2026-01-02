<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class PickupPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'location',    
        'is_active',
    ];

    protected $casts = [
        'location' => 'array',
        'is_active' => 'boolean',
    ];

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'location' => ['required', 'array'],
            'location.lat' => ['required', 'numeric', 'between:-90,90'],
            'location.lng' => ['required', 'numeric', 'between:-180,180'],
            'is_active' => ['boolean'],
        ];
    }

    public function validationMessages(): array
    {
        return [
            'location.required' => 'Пожалуйста, выберите точку на карте.',
            'location.lat.between' => 'Неверная широта.',
            'location.lng.between' => 'Неверная долгота.',
        ];
    }

    public function getCoordinates(): array
    {
        return $this->location ?: [43.238949, 76.889709];
    }
}