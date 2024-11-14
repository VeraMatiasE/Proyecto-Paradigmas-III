<?php
function getFormattedDate($datetime)
{
    try {
        $dateTimeObj = new DateTime($datetime, new DateTimeZone('America/Argentina/Buenos_Aires'));

        $dateFormatted = class_exists('IntlDateFormatter') ?
            $dateFormatted = IntlDateFormatter::formatObject(
                $dateTimeObj,
                'eeee d MMMM y, HH:mm',
                'es'
            ) : $dateTimeObj->format('l d F Y, H:i');

        return htmlspecialchars(ucwords($dateFormatted), ENT_QUOTES, 'UTF-8');

    } catch (Exception $e) {
        return 'Fecha inválida';
    }
}