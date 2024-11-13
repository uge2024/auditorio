require('./bootstrap');

import {
    Calendar
} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [{
                    title: 'Event 1',
                    start: '2024-08-01'
                },
                {
                    title: 'Event 2',
                    start: '2024-08-07',
                    end: '2024-08-10'
                }
            ]
        });

        calendar.render();
    }
});
