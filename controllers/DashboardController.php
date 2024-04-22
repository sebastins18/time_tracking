<?php
// Path: controllers/DashboardController.php

require_once('helpers/general_helpers.php');
require_once('models/Event.php');

class DashboardController extends Controller {

    public function userDashboard() {
        $view = $_GET['view'] ?? 'month';
        $year = $_GET['year'] ?? date("Y");
        $month = $_GET['month'] ?? date("m");
        $day = $_GET['day'] ?? date("d");
        $userId = $_SESSION['user']['id_user'];
        $events = Event::getByUserAndMonth($userId, $month, $year);

        $date = new DateTime("$year-$month-$day");
        if ($view === 'day') {
            $prevDate = clone $date;
            $prevDate->modify('-1 day');
            $nextDate = clone $date;
            $nextDate->modify('+1 day');
        } elseif ($view === 'week') {
            $date->modify('Monday this week');
            $prevDate = clone $date;
            $prevDate->modify('-1 week');
            $nextDate = clone $date;
            $nextDate->modify('+1 week');
        } else {
            $prevDate = clone $date;
            $prevDate->modify('first day of last month');
            $nextDate = clone $date;
            $nextDate->modify('first day of next month');
        }


        $calendar = "";
        switch ($view) {
            case 'day':
                $calendar = generateCalendarDay($year, $month, $day, $events);
                break;
            case 'week':
                $calendar = generateCalendarWeek($year, $month, $day, $events);
                break;
            case 'month':
            default:
                $calendar = generateCalendar($year, $month, $events);
                break;
        }

        return view('user/dashboard_user', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'prevYear' => $prevDate->format('Y'),
            'prevMonth' => $prevDate->format('m'),
            'prevDay' => $prevDate->format('d'),
            'nextYear' => $nextDate->format('Y'),
            'nextMonth' => $nextDate->format('m'),
            'nextDay' => $nextDate->format('d'),
            'calendar' => $calendar,
            'view' => $view
        ]);
    }
}
?>
