<?php

use Illuminate\Support\Facades\Route;
use Laravelgpt\CountryCode\Http\Controllers\CountryController;

Route::prefix('countries')->group(function () {
    // Get all countries with pagination and filtering
    Route::get('/', [CountryController::class, 'index'])->name('countries.index');
    
    // Get a specific country by ISO code
    Route::get('/{code}', [CountryController::class, 'show'])->name('countries.show');
    
    // Search countries
    Route::get('/search', [CountryController::class, 'search'])->name('countries.search');
    
    // Get countries by phone code
    Route::get('/phone/{phoneCode}', [CountryController::class, 'byPhoneCode'])->name('countries.by-phone-code');
    
    // Get countries by continent
    Route::get('/continent/{continent}', [CountryController::class, 'byContinent'])->name('countries.by-continent');
    
    // Get countries by region
    Route::get('/region/{region}', [CountryController::class, 'byRegion'])->name('countries.by-region');
    
    // Get all continents
    Route::get('/continents', [CountryController::class, 'continents'])->name('countries.continents');
    
    // Get all regions
    Route::get('/regions', [CountryController::class, 'regions'])->name('countries.regions');
    
    // Get countries by regional grouping
    Route::get('/group/{group}', [CountryController::class, 'byRegionalGroup'])->name('countries.by-group');
    
    // Get phone code statistics
    Route::get('/stats/phone', [CountryController::class, 'phoneStats'])->name('countries.phone-stats');
    
    // Validate country code
    Route::post('/validate', [CountryController::class, 'validate'])->name('countries.validate');
    
    // Get UN member countries
    Route::get('/un-members', [CountryController::class, 'unMembers'])->name('countries.un-members');
    
    // Get independent countries
    Route::get('/independent', [CountryController::class, 'independent'])->name('countries.independent');
    
    // Get default country
    Route::get('/default', [CountryController::class, 'default'])->name('countries.default');
}); 