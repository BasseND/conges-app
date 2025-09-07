<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UsersTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'Jean',
                'Dupont',
                'M',
                'jean.dupont@example.com',
                '0123456789',
                'Développeur',
                'employee',
                'Informatique',
                'password123',
                'non',
                'marié',
                'fonctionnaire',
                '2',
                'MAT001',
                'Direction Générale',
                'cadre',
                'Section IT',
                'Service Développement'
            ],
            [
                'Marie',
                'Martin',
                'F',
                'marie.martin@example.com',
                '0987654321',
                'Chef de projet',
                'manager',
                'Marketing',
                'password123',
                'oui',
                'célibataire',
                'contractuel_cdi',
                '0',
                'MAT002',
                'Direction Marketing',
                'agent_de_maitrise',
                'Section Communication',
                'Service Digital'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'prenom',
            'nom',
            'sexe',
            'email',
            'telephone',
            'poste',
            'role',
            'departement',
            'mot_de_passe',
            'prestataire',
            'etat_civil',
            'statut_professionnel',
            'nombre_enfants',
            'matricule',
            'affectation',
            'categorie',
            'section',
            'service'
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
            '2:3' => [
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
            'A' => 15, // prenom
            'B' => 15, // nom
            'C' => 8,  // sexe
            'D' => 25, // email
            'E' => 15, // telephone
            'F' => 20, // poste
            'G' => 15, // role
            'H' => 20, // departement
            'I' => 15, // mot_de_passe
            'J' => 12, // prestataire
            'K' => 15, // etat_civil
            'L' => 20, // statut_professionnel
            'M' => 12, // nombre_enfants
            'N' => 12, // matricule
            'O' => 20, // affectation
            'P' => 15, // categorie
            'Q' => 15, // section
            'R' => 20, // service
        ];
    }
}