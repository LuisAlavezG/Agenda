<!DOCTYPE html>
<html>
<head>
    <title>Agenda</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.1/main.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.10.1/main.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: 'get_events.php',
                dateClick: function(info) {
                    var title = prompt('Event Title:');
                    var description = prompt('Event Description:');
                    var start = info.dateStr;

                    if (title) {
                        fetch('create_event.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                title: title,
                                description: description,
                                start: start,
                                end: start
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.id) {
                                calendar.addEvent({
                                    id: data.id,
                                    title: title,
                                    start: start,
                                    end: start,
                                    description: description
                                });
                                alert('Evento creado');
                            } else {
                                alert('Error creando evento');
                            }
                        });
                    }
                },
                eventClick: function(info) {
                    if (confirm("¿Seguro que quieres eliminar este evento?")) {
                        fetch('delete_event.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                id: info.event.id
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                info.event.remove();
                                alert('Evento eliminado');
                            } else {
                                alert('Error eliminando evento');
                            }
                        });
                    }
                }
            });

            calendar.render();
        });
    </script>
</head>
<body>
    <h1>Agenda</h1>
    <div id='calendar'></div>
</body>
</html>
