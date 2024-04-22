<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Usuario</title>
    <link rel="stylesheet" href="/views/user/css/dashboard_user.css">
</head>
<body>
<nav class="navbar">
    <ul>
        <li><a href="/logout">Cerrar Sesión</a></li>
        <li>
            <form action="/user/dashboard_user" method="get">
                <select name="view" onchange="this.form.submit()">
                    <option value="month" <?php echo $view === 'month' ? 'selected' : ''; ?>>Mes</option>
                    <option value="week" <?php echo $view === 'week' ? 'selected' : ''; ?>>Semana</option>
                    <option value="day" <?php echo $view === 'day' ? 'selected' : ''; ?>>Día</option>
                </select>
                <input type="hidden" name="year" value="<?php echo $year; ?>">
                <input type="hidden" name="month" value="<?php echo $month; ?>">
                <input type="hidden" name="day" value="<?php echo $day; ?>">
            </form>
        </li>
        <li><a href="/event/create" class="button add-event">Agregar Evento</a></li>
    </ul>
</nav>
<div class="container">
    <h1>Dashboard del Usuario</h1>
    <div class="navigation">
        <a href="/user/dashboard_user?view=<?php echo $view; ?>&year=<?php echo $prevYear; ?>&month=<?php echo $prevMonth; ?>&day=<?php echo $prevDay; ?>" class="button nav">Anterior</a>
        <a href="/user/dashboard_user?view=<?php echo $view; ?>&year=<?php echo $nextYear; ?>&month=<?php echo $nextMonth; ?>&day=<?php echo $nextDay; ?>" class="button nav">Siguiente</a>
    </div>
    <table>
        <thead>
            <tr>
                <?php foreach ($weekdays as $day): ?>
                    <th><?php echo $day; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php echo $calendar; ?>
        </tbody>
    </table>
</div>
</body>
</html>
