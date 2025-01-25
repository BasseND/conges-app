<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Leave;

class LeaveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {


        // dd([
        //     'data' => $this->all(),
        //     'start_date' => $this->start_date,
        //     'end_date' => $this->end_date,
        //     'type' => $this->type,
        //     'reason' => $this->reason,
        // ]);

         $rules = [
            'start_date' => [
                'required', 
                'date', 
                
                'before:+1 year',
                function ($attribute, $value, $fail) {
                    $startDate = Carbon::parse($value);
                    if ($startDate->isWeekend()) {
                        $fail('La date de début ne peut pas être un weekend.');
                    }
                }
            ],
           'end_date' => [
                'required', 
                'date', 
                'after_or_equal:start_date',
                function ($attribute, $value, $fail) {
                    $endDate = Carbon::parse($value);
                    if ($endDate->isWeekend()) {
                        $fail('La date de fin ne peut pas être un weekend.');
                    }

                    if (!$this->start_date) {
                        return;
                    }

                    $startDate = Carbon::parse($this->start_date);
                    
                    // Vérifie les chevauchements avec d'autres congés
                    $existingLeave = Leave::query()
                        ->where('user_id', auth()->id())
                        ->where('status', '!=', 'rejected')
                        ->where(function ($query) use ($startDate, $endDate) {
                            $query->where(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $startDate)
                                  ->where('end_date', '>=', $startDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $endDate)
                                  ->where('end_date', '>=', $endDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '>=', $startDate)
                                  ->where('end_date', '<=', $endDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('start_date', '<=', $startDate)
                                  ->where('end_date', '>=', $endDate);
                            });
                        })
                        ->first();

                    if ($existingLeave) {
                        $fail(sprintf(
                            'Cette période chevauche un congé existant du %s au %s.',
                            $existingLeave->start_date->format('d/m/Y'),
                            $existingLeave->end_date->format('d/m/Y')
                        ));
                        return;
                    }

                    // Vérifie la durée maximale selon le type de congé
                    $duration = 0;
                    for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
                        if (!$date->isWeekend()) {
                            $duration++;
                        }
                    }
                    $maxDuration = $this->getMaxDurationForLeaveType($this->type);
                    if ($duration > $maxDuration) {
                        $fail("La durée maximale pour ce type de congé est de {$maxDuration} jours ouvrables.");
                    }
                }
            ],
            'type' => [
                'required', 
                Rule::in(['annual', 'sick', 'unpaid', 'other'])
            ],
            'reason' => [
                'required', 
                'string', 
                'min:10', 
                'max:500'
            ],
            'attachments.*' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:2048' // 2MB max
            ],
            // Règle personnalisée pour vérifier les chevauchements
            'period' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->start_date || !$this->end_date) {
                        return;
                    }

                    $startDate = Carbon::parse($this->start_date);
                    $endDate = Carbon::parse($this->end_date);

                    $existingLeave = Leave::query()
                        ->where('user_id', auth()->id())
                        ->where('status', '!=', 'rejected')
                        ->where(function ($query) use ($startDate, $endDate) {
                            // Vérifie les 4 cas possibles de chevauchement
                            $query->where(function ($q) use ($startDate, $endDate) {
                                // Cas 1: La nouvelle période commence pendant un congé existant
                                $q->where('start_date', '<=', $startDate)
                                  ->where('end_date', '>=', $startDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                // Cas 2: La nouvelle période finit pendant un congé existant
                                $q->where('start_date', '<=', $endDate)
                                  ->where('end_date', '>=', $endDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                // Cas 3: La nouvelle période englobe un congé existant
                                $q->where('start_date', '>=', $startDate)
                                  ->where('end_date', '<=', $endDate);
                            })->orWhere(function ($q) use ($startDate, $endDate) {
                                // Cas 4: La nouvelle période est entièrement incluse dans un congé existant
                                $q->where('start_date', '<=', $startDate)
                                  ->where('end_date', '>=', $endDate);
                            });
                        })
                        ->first();

                    if ($existingLeave) {
                        $fail(sprintf(
                            'Cette période chevauche un congé existant du %s au %s.',
                            $existingLeave->start_date->format('d/m/Y'),
                            $existingLeave->end_date->format('d/m/Y')
                        ));
                    }
                }
            ]
        ];

        //  dd('Validation rules passed', $this->all());
        return $rules;


    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'La date de début est requise.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'start_date.before' => 'La date de début ne peut pas être plus d\'un an dans le futur.',
            'end_date.required' => 'La date de fin est requise.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'end_date.before' => 'La durée du congé ne peut pas dépasser 3 mois.',
            'type.required' => 'Le type de congé est requis.',
            'type.in' => 'Le type de congé sélectionné n\'est pas valide.',
            'reason.required' => 'La raison est requise.',
            'reason.min' => 'Veuillez fournir une raison plus détaillée (minimum 10 caractères).',
            'reason.max' => 'La raison ne peut pas dépasser 500 caractères.',
            'attachments.*.mimes' => 'Les pièces jointes doivent être au format PDF, DOC, DOCX, JPG, JPEG ou PNG.',
            'attachments.*.max' => 'Les pièces jointes ne doivent pas dépasser 2 Mo.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        // -
    }

    /**
     * Prepare the data for validation.
     */
     protected function prepareForValidation(): void
    {
        if ($this->start_date) {
            $this->merge([
                'start_date' => date('Y-m-d', strtotime($this->start_date)),
            ]);
        }
        if ($this->end_date) {
            $this->merge([
                'end_date' => date('Y-m-d', strtotime($this->end_date)),
            ]);
        }
    }

    /**
     * Get the maximum duration allowed for a leave type.
     */
    private function getMaxDurationForLeaveType(string $type): int
    {
        return match($type) {
            'annual' => 30,  // 30 jours maximum pour les congés annuels
            'sick' => 90,    // 90 jours maximum pour les congés maladie
            'unpaid' => 60,  // 60 jours maximum pour les congés sans solde
            'other' => 5,    // 5 jours maximum pour les autres types
            default => 30,
        };
    }
}
