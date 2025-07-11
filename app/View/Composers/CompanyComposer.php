<?php

namespace App\View\Composers;

use App\Models\Company;
use Illuminate\View\View;

class CompanyComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $company = Company::first();
        
        $view->with([
            'globalCompany' => $company,
            'globalCompanyName' => $company ? $company->name : 'Eglantine SA',
            'globalCompanyAddress' => $company ? $this->formatAddress($company) : '23 rue de la paix, Dakar',
            'globalCompanyCurrency' => $company ? $company->currency : '€'
        ]);
    }
    
    /**
     * Format the company address
     *
     * @param  \App\Models\Company  $company
     * @return string
     */
    private function formatAddress(Company $company)
    {
        $address = $company->address;
        
        if ($company->city) {
            $address .= ', ' . $company->city;
        }
        
        if ($company->country) {
            $address .= ', ' . $company->country;
        }
        
        return $address ?: '23 rue de la paix, Dakar';
    }
}