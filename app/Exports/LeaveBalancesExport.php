<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LeaveBalancesExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected array $rows;

    public function __construct(Collection $balances)
    {
        $this->rows = $balances->map(function ($balance) {
            return [
                $balance->user->matricule ?? '',
                $balance->user->first_name ?? '',
                $balance->user->last_name ?? '',
                optional($balance->user->department)->name ?? '',
                $balance->specialLeaveType->name ?? '',
                $balance->year,
                $balance->initial_balance,
                $balance->used_balance,
                $balance->adjustment_balance,
                $balance->current_balance,
                $balance->notes ?? '',
            ];
        })->toArray();
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Matricule',
            'Prénom',
            'Nom',
            'Département',
            'Type de congé',
            'Année',
            'Solde initial',
            'Solde utilisé',
            'Ajustements',
            'Solde actuel',
            'Notes',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour les en-têtes
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4472C4'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Matricule
            'B' => 15, // Prénom
            'C' => 15, // Nom
            'D' => 25, // Département
            'E' => 25, // Type de congé
            'F' => 10, // Année
            'G' => 15, // Solde initial
            'H' => 15, // Solde utilisé
            'I' => 15, // Ajustements
            'J' => 15, // Solde actuel
            'K' => 40, // Notes
        ];
    }
}