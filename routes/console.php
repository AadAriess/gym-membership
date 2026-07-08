<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('billing:generate')->monthlyOn(1, '00:00');
Schedule::command('billing:check-overdue')->dailyAt('01:00');
