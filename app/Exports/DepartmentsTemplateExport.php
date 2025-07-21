<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DepartmentsTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Informatique',
                'IT',
                'Département en charge du développement et de la maintenance des systèmes informatiques',
                'chef.it@example.com',
                'Ma Société',
                'Solde Standard'
            ],
            [
                'Ressources Humaines',
                'RH',
                'Département en charge de la gestion du personnel et des ressources humaines',
                'chef.rh@example.com',
                'Ma Société',
                'Solde Cadre'
            ],
            [
                'Marketing',
                'MKT',
                'Département en charge de la promotion et de la communication',
                '',
                '',
                ''
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'code',
            'description',
            'chef_email',
            'societe',
            'solde_conges'
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
            // Style pour les exemples
            '2:4' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'E7F3FF'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // nom
            'B' => 10, // code
            'C' => 40, // description
            'D' => 25, // chef_email
            'E' => 20, // societe
            'F' => 20, // solde_conges
        ];
    }
}