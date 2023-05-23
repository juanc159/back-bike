<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuSeeder::class, 
            PermissionSeeder::class, 
            PlanesSeeder::class, 
            UserSeeder::class, 
            CompanySeeder::class, 
            RoleSeeder::class, 
            UserEmployeSeeder::class,

            LedgerAccountClassSeeder::class, 
            LedgerAccountGroupSeeder::class, 
            LedgerAccountAccountSeeder::class, 
            LedgerAccountSubAccountSeeder::class,
            LedgerAccountCategorySeeder::class,
            LedgerAccountBalanceSeeder::class, 
            PaymentMethodSeeder::class, 
            RelatedToSeeder::class, 
            LedgerAccountAuxiliarySeeder::class,
            TypeOfThirdSeeder::class,
            BasicDataTypeSeeder::class,
            TypeRegimeIvaSeeder::class,
            FiscalResponsabilitySeeder::class,
            TypeIdentificationSeeder::class,
            DepartamentSeeder::class,
            CitieSeeder::class,
            //ChargeCatalogSeeder::class,
            FormatDisplayPrintInvoiceSeeder::class,
            DiscountPerItemSeeder::class,
            TypeChargeAndDiscountSeeder::class,
            ValidityInMonthSeeder::class,
            TypeContractSeeder::class, 
            DetailInvoiceAvailableSeeder::class,
            ReasonRetirementSeeder::class,
            PayrollGroupSeeder::class,
            ContributingTypeSeeder::class,
            ContributingSubTypeSeeder::class, 
            HealthBackgroundSeeder::class, 
            PensionFundSeeder::class,
            CompensationBoxSeeder::class,
            ArlSeeder::class,
            RiskClassSeeder::class,
            BankSeeder::class,
            AccountTypeSeeder::class,
            GeneralParametrizationSeeder::class,
            TaxChargeSeeder::class,
            WithholdingTaxeSeeder::class,
            CurrencySeeder::class, 
            TypeProductSeeder::class,
            TaxClassificationSeeder::class,
            UnitOfMeasurementInvoiceSeeder::class,
            AddPermissionConfigurationBoxToAccountantPlan::class,
            PerformASeeder::class,
            AddPermissionQuotes::class,
            DetailQuoteAvailableSeeder::class,
            AddPermissionTypesQuotesSeeder::class,
            StatesQuoteSeed::class,
            DianReasonSeeder::class
        ]);
    }
}
