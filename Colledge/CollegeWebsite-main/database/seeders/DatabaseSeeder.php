<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LayoutPageSeeder::class,
            HomePageSeeder::class,
            AboutPageSeeder::class,
            NewsPageSeeder::class,
            NewsPageTextSeeder::class,
            NewsShowPageSeeder::class,
            BlogPageSeeder::class,
            StaffPageSeeder::class,
            CuratorsPageSeeder::class,
            CouncilsPageSeeder::class,
            GovernmentServicesPageSeeder::class,
            DocumentsPageSeeder::class,
            AnticorruptionPageSeeder::class,
            NormativeDocumentsPageSeeder::class,
            LaborProtectionPageSeeder::class,
            UnionEducationPageSeeder::class,
            TradeUnionPageSeeder::class,
            AchievementsPageSeeder::class,
            YouthMovementPageSeeder::class,
            SearchPageSeeder::class,
            PhonebookPageSeeder::class,
            LibraryPageSeeder::class,
            FaqPageSeeder::class,
            VacanciesPageSeeder::class,
            CollaborationsPageSeeder::class,
            StateSymbolsPageSeeder::class,
            VirtualTourPageSeeder::class,
            DashboardSeeder::class,
            DashboardStatisticSeeder::class,
        ]);
    }
}