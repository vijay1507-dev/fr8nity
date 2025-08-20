<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helper
{
    /**
     * Get current year or fallback to default
     */
    public static function getCurrentYear(?string $requestedYear = null): int
    {
        if ($requestedYear && is_numeric($requestedYear)) {
            $year = (int) $requestedYear;
            if ($year >= 2020 && $year <= (date('Y') + 1)) {
                return $year;
            }
        }
        
        return (int) date('Y');
    }

    /**
     * Validate year parameter
     */
    public static function validateYear(?string $year): bool
    {
        if (!$year || !is_numeric($year)) {
            return false;
        }
        
        $yearInt = (int) $year;
        return $yearInt >= 2020 && $yearInt <= (date('Y') + 1);
    }

    /**
     * Format number with proper formatting
     */
    public static function formatNumber($number, int $decimals = 0): string
    {
        return number_format($number, $decimals);
    }

    /**
     * Get available years for filter dropdown
     */
    public static function getAvailableYears(): array
    {
        $currentYear = (int) date('Y');
        $years = [];
        
        for ($year = $currentYear; $year >= 2020; $year--) {
            $years[] = $year;
        }
        
        return $years;
    }

    /**
     * Get period label for dashboard filters
     */
    public static function getPeriodLabel(int $period): string
    {
        return match($period) {
            3 => 'Last 3 months',
            6 => 'Last 6 months',
            12 => 'Last 1 year',
            default => 'Custom period'
        };
    }
}
