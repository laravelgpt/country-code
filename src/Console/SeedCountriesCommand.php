<?php

namespace Laravelgpt\CountryCode\Console;

use Illuminate\Console\Command;
use Laravelgpt\CountryCode\Database\Seeders\CountrySeeder;

class SeedCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'country-code:seed {--force : Force the operation to run}';

    /**
     * The console command description.
     */
    protected $description = 'Seed the countries table with comprehensive country data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (!$this->option('force') && !$this->confirm('This will seed the countries table. Do you wish to continue?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info('Seeding countries table...');

        try {
            $seeder = new CountrySeeder();
            $seeder->run();

            $this->info('Countries seeded successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to seed countries: ' . $e->getMessage());
            return 1;
        }
    }
} 