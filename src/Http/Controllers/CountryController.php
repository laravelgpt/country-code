<?php

namespace Laravel\CountryCode\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\CountryCode\Models\Country;
use Laravel\CountryCode\Services\CountryCodeService;

class CountryController extends Controller
{
    protected CountryCodeService $countryService;

    public function __construct(CountryCodeService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Get all countries with optional pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search');
        $continent = $request->get('continent');
        $region = $request->get('region');
        $status = $request->get('status', 'active');

        $query = Country::query();

        if ($search) {
            $query->search($search);
        }

        if ($continent) {
            $query->inContinent($continent);
        }

        if ($region) {
            $query->inRegion($region);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $countries = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'data' => $countries->items(),
            'pagination' => [
                'current_page' => $countries->currentPage(),
                'last_page' => $countries->lastPage(),
                'per_page' => $countries->perPage(),
                'total' => $countries->total(),
            ],
        ]);
    }

    /**
     * Get a specific country by ISO code.
     */
    public function show(string $code): JsonResponse
    {
        $country = $this->countryService->findByIso($code);

        if (!$country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

        return response()->json([
            'data' => $country,
        ]);
    }

    /**
     * Search countries by various criteria.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([
                'message' => 'Search query is required',
            ], 400);
        }

        $countries = $this->countryService->search($query);

        return response()->json([
            'data' => $countries,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get countries by phone code.
     */
    public function byPhoneCode(string $phoneCode): JsonResponse
    {
        $countries = $this->countryService->findByPhoneCode($phoneCode);

        return response()->json([
            'data' => $countries,
            'phone_code' => $phoneCode,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get countries by continent.
     */
    public function byContinent(string $continent): JsonResponse
    {
        $countries = $this->countryService->getByContinent($continent);

        return response()->json([
            'data' => $countries,
            'continent' => $continent,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get countries by region.
     */
    public function byRegion(string $region): JsonResponse
    {
        $countries = $this->countryService->getByRegion($region);

        return response()->json([
            'data' => $countries,
            'region' => $region,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get all continents.
     */
    public function continents(): JsonResponse
    {
        $continents = $this->countryService->getContinents();

        return response()->json([
            'data' => $continents,
        ]);
    }

    /**
     * Get all regions.
     */
    public function regions(): JsonResponse
    {
        $regions = $this->countryService->getRegions();

        return response()->json([
            'data' => $regions,
        ]);
    }

    /**
     * Get countries by regional grouping.
     */
    public function byRegionalGroup(string $group): JsonResponse
    {
        $countries = $this->countryService->getByRegionalGroup($group);

        return response()->json([
            'data' => $countries,
            'group' => $group,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get phone code statistics.
     */
    public function phoneStats(): JsonResponse
    {
        $stats = $this->countryService->getPhoneCodeStats();

        return response()->json([
            'data' => $stats,
        ]);
    }

    /**
     * Validate a country code.
     */
    public function validate(Request $request): JsonResponse
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json([
                'message' => 'Country code is required',
            ], 400);
        }

        $isValid = $this->countryService->validate($code);

        return response()->json([
            'valid' => $isValid,
            'code' => $code,
        ]);
    }

    /**
     * Get UN member countries.
     */
    public function unMembers(): JsonResponse
    {
        $countries = $this->countryService->getUnMembers();

        return response()->json([
            'data' => $countries,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get independent countries.
     */
    public function independent(): JsonResponse
    {
        $countries = $this->countryService->getIndependent();

        return response()->json([
            'data' => $countries,
            'total' => $countries->count(),
        ]);
    }

    /**
     * Get default country.
     */
    public function default(): JsonResponse
    {
        $country = $this->countryService->getDefaultCountry();

        return response()->json([
            'data' => $country,
        ]);
    }
} 