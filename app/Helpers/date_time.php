<?php

use Carbon\CarbonPeriod;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

if (!function_exists('timeToSeconds')) {

    /**
     * Convertit une chaîne de caractères représentant une durée au format HH:MM:SS ou MM:SS en secondes.
     *
     * @param string $time La chaîne de caractères représentant la durée.
     * @return int La durée en secondes.
     * @throws InvalidArgumentException Si le format de la chaîne n'est pas valide.
     */
    function timeToSeconds($time) {
        $parts = explode(':', $time);

        if (count($parts) === 3) {
            [$hours, $minutes, $seconds] = $parts;
        }
        elseif (count($parts) === 2) {
            [$hours, $minutes] = $parts;
            $seconds = 0;
        }
        else {
            throw new InvalidArgumentException("Format d'heure invalide : $time");
        }

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

}

if (!function_exists('formatSecondToTime')) {

    /**
     * Formate une durée en secondes au format spécifié.
     *
     * @param int $seconds La durée en secondes.
     * @param string $format Le format de sortie (par défaut "HH:mm:ss").
     * @return string La durée formatée.
     */
    function formatSecondToTime(int $seconds, string $format = "H:i:s"): string {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        $hh = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $mm = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $ss = str_pad($secs, 2, '0', STR_PAD_LEFT);

        return str_replace(['H', 'i', 's'], [$hh, $mm, $ss], $format);
    }
}

if(!function_exists('secondsToDays')) {
    /**
     * Convertit un nombre de secondes en jours.
     *
     * @param int $seconds Le nombre de secondes à convertir.
     * @param int $precision Le nombre de décimales à afficher (par défaut 2).
     * @return float Le nombre de jours correspondant.
     */
    function secondsToDays(int $seconds, int $precision = 0): float {
        return round($seconds / (60 * 60 * 24), $precision, PHP_ROUND_HALF_UP);
    }
}

if(!function_exists('dayToSecond')) {
    /**
     * Convertit un nombre de jours en secondes.
     *
     * @param float $days Le nombre de jours à convertir.
     * @return float Le nombre de secondes correspondant.
     */
    function dayToSecond(float $days): float {
        return round($days * (60 * 60 * 24), 0, PHP_ROUND_HALF_UP);
    }
}


if(!function_exists('periodToSeconde')) {
    /**
     * Calcule la différence en secondes entre deux dates, en acceptant plusieurs formats.
     * Peut optionnellement exclure les jours de week-end (samedi, dimanche).
     *
     * Lorsque $noWeekend est true, la fonction compte le nombre de jours ouvrés *entiers*
     * compris entre la date de début et la date de fin (inclusives) et multiplie par 86400.
     * L'heure exacte des dates de début et de fin est ignorée dans ce mode.
     *
     * Lorsque $noWeekend est false, la fonction calcule la différence exacte en secondes
     * entre les deux dates/heures fournies.
     *
     * @param string $date_debut_str La date de début (formats acceptés: 'Y-m-d' ou format ISO 8601 comme 'Y-m-d\TH:i:s.u\Z').
     * @param string $date_fin_str La date de fin (formats acceptés: 'Y-m-d' ou format ISO 8601 comme 'Y-m-d\TH:i:s.u\Z').
     * @param bool $noWeekend Si true, ne compte que les secondes des jours de semaine entiers (86400s par jour ouvré).
     * @return int Le nombre total de secondes.
     * @throws \InvalidArgumentException Si les dates ne peuvent pas être parsées par Carbon.
     */
    function periodToSeconde(string $date_debut_str, string $date_fin_str, bool $includeLast = true, bool $noWeekend = false): int
    {
        try {
            $date_debut = Carbon::parse($date_debut_str);
            $date_fin = Carbon::parse($date_fin_str);

            if ($date_fin->isBefore($date_debut)) {
                throw new \InvalidArgumentException("La date de fin ne peut pas être antérieure à la date de début.");
            }

        } catch (InvalidFormatException $e) {
            throw new \InvalidArgumentException("Format de date invalide fourni. Formats acceptés: 'Y-m-d' ou ISO 8601 (ex: '2025-05-01T10:00:00Z'). Erreur originale: " . $e->getMessage(), 0, $e);
        }

        $start = $date_debut->copy()->startOfDay();
        $end = $includeLast ? $date_fin->copy()->endOfDay() : $date_fin->copy()->startOfDay();

        if ($noWeekend) {
            $period = CarbonPeriod::create($start, $end);
            $totalSeconds = 0;
            foreach ($period as $date) {
                if (!$date->isWeekend()) {
                    $totalSeconds += 86400;
                }
            }

            return $totalSeconds;
        } else {
            return $start->diffInSeconds($end);
        }
    }
}
