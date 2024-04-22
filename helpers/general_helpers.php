<?php
// Path: helpers/general_helpers.php
function generateCalendar($year, $month, $events) {
    $date = new DateTime("$year-$month-01");
    $date->modify('first day of this month');
    $firstDayOfWeek = $date->format('N');
    $html = "<tr>";
    $dayOfWeekCount = $firstDayOfWeek - 1;

    for ($i = 1; $i < $firstDayOfWeek; $i++) {
        $html .= "<td></td>"; // Llena los días vacíos al comienzo del mes
    }

    while ($date->format('m') == $month) {
        if ($dayOfWeekCount == 7) {
            $html .= "</tr><tr>";
            $dayOfWeekCount = 0;
        }

        $dayHtml = "<td class='day-cell'>";
        $eventHtml = "";
        foreach ($events as $event) {
            $eventDate = (new DateTime($event['start_time']))->format('Y-m-d');
            if ($eventDate == $date->format('Y-m-d')) {
                $eventHtml .= "<div class='event'><a href='/event/{$event['id_event']}' title='" . htmlspecialchars($event['title']) . "'>" . htmlspecialchars($event['description']) . "</a></div>";
            }
        }

        // Agrega la fecha al día y cualquier evento
        $dateLabel = $date->format('d');
        $dayHtml .= "<div class='date" . (!empty($eventHtml) ? " has-event" : "") . "'>$dateLabel</div>";
        $dayHtml .= $eventHtml;
        $dayHtml .= "</td>";

        $html .= $dayHtml;
        $date->modify('+1 day');
        $dayOfWeekCount++;
    }

    if ($dayOfWeekCount != 7) {
        for ($i = $dayOfWeekCount; $i < 7; $i++) {
            $html .= "<td></td>"; // Llena los días vacíos al final del mes
        }
    }
    $html .= "</tr>";

    return $html;
}

function generateCalendarDay($year, $month, $day, $events) {
    $date = new DateTime("$year-$month-$day");
    $html = "<tr>";
    $dayHtml = "<td class='day-cell'>";
    $eventHtml = "";

    foreach ($events as $event) {
        $eventStartTime = new DateTime($event['start_time']);
        if ($eventStartTime->format('Y-m-d') == $date->format('Y-m-d')) {
            $eventHtml .= "<div class='event'><a href='/event/{$event['id_event']}' title='" . htmlspecialchars($event['title']) . "'>" . htmlspecialchars($event['description']) . "</a></div>";
        }
    }

    if (empty($eventHtml)) {
        $eventHtml = "<div class='no-event'>No hay eventos.</div>";
    }

    $dayHtml .= $eventHtml;
    $dayHtml .= "</td>";
    $html .= $dayHtml;
    $html .= "</tr>";

    return $html;
}


function generateCalendarWeek($year, $month, $day, $events) {
    $startDate = new DateTime("$year-$month-$day");
    $startDate->modify('Monday this week');
    $endDate = clone $startDate;
    $endDate->modify('Sunday this week');

    $html = "<tr>";
    while ($startDate <= $endDate) {
        $dayHtml = "<td class='day-cell'>";
        $eventHtml = "";
        foreach ($events as $event) {
            $eventStartTime = new DateTime($event['start_time']);
            if ($eventStartTime->format('Y-m-d') == $startDate->format('Y-m-d')) {
                $eventHtml .= "<div class='event'><a href='/event/{$event['id_event']}' title='" . htmlspecialchars($event['title']) . "'>" . htmlspecialchars($event['description']) . "</a></div>";
            }
        }

        $dayHtml .= "<div class='date'>" . $startDate->format('d') . "</div>";
        $dayHtml .= $eventHtml . "</td>";
        $html .= $dayHtml;
        $startDate->modify('+1 day');
    }
    $html .= "</tr>";

    return $html;
}


// Path: helpers/general_helpers.php
function getWeekdayHeaders($view = 'month', $startDay = 'Monday') {
    $weekdays = [];
    $date = new DateTime($startDay);
    $date->modify($startDay);

    if ($view === 'day') {
        // Solo muestra el día actual
        $weekdays[] = $date->format('l');
    } else if ($view === 'week') {
        // Muestra toda la semana desde el lunes hasta el domingo
        $date->modify('Monday this week');
        for ($i = 0; $i < 7; $i++) {
            $weekdays[] = $date->format('l');
            $date->modify('+1 day');
        }
    } else {
        // Muestra toda la semana típica de lunes a domingo
        for ($i = 0; $i < 7; $i++) {
            $weekdays[] = $date->format('l');
            $date->modify('+1 day');
        }
    }

    return $weekdays;
}


