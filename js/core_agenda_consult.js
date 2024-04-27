document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'UTC',
        locale: 'fr',
        allDaySlot: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        initialView: 'timeGridWeek',
        slotDuration: "00:30:00",
        slotLabelInterval: "00:30:00",
        slotLabelFormat: [
            {
                hour: 'numeric',
                minute: '2-digit',
                omitZeroMinute: false,
                meridiem: 'short'
            }
        ],
        buttonText: {
            timeGridWeek: 'Semaine',
            timeGridDay: 'Jour'
        },
        editable: true,
        hiddenDays: [0],
        firstDay: 1,
        expandRows: true,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridDay,timeGridWeek'
        },
        events: './src/agenda_slot.php',

    });

    calendar.render();
});

