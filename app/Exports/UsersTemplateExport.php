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
                '1990-05-15',
                '123 Rue de la Paix, Paris',
                'marié',
                '2',
                'fonctionnaire',
                'MAT001',
                'Direction Générale',
                'cadre',
                'Section IT',
                'Service Développement',
                '2020-01-15',
                '',
                'Pierre Dupont',
                '0123456788',
                'Frère'
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
                '1985-12-03',
                '456 Avenue des Champs, Lyon',
                'célibataire',
                '0',
                'contractuel_cdi',
                'MAT002',
                'Direction Marketing',
                'agent_de_maitrise',
                'Section Communication',
                'Service Digital',
                '2019-03-01',
                '',
                'Sophie Martin',
                '0987654320',
                'Mère'
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
            'date_naissance',
            'adresse',
            'etat_civil',
            'nombre_enfants',
            'statut_professionnel',
            'matricule',
            'affectation',
            'categorie',
            'section',
            'service',
            'date_entree',
            'date_sortie',
            'contact_urgence_nom',
            'contact_urgence_telephone',
            'contact_urgence_relation'
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
            'K' => 15, // date_naissance
            'L' => 30, // adresse
            'M' => 15, // etat_civil
            'N' => 12, // nombre_enfants
            'O' => 20, // statut_professionnel
            'P' => 12, // matricule
            'Q' => 20, // affectation
            'R' => 15, // categorie
            'S' => 15, // section
            'T' => 20, // service
            'U' => 15, // date_entree
            'V' => 15, // date_sortie
            'W' => 20, // contact_urgence_nom
            'X' => 18, // contact_urgence_telephone
            'Y' => 15, // contact_urgence_relation
        ];
    }
}