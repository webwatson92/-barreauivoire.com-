
<html>
<head>
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css' rel='stylesheet' />
    @livewireStyles
</head>
<body>
    <livewire:calendar />
    @livewireScripts
    <!-- @stack('scripts') -->
    @push('script')

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script> -->

        <script>
            // document.addEventListener('DOMContentLoaded', function () {
            //     var calendarEl = document.getElementById('calendar');
            //     var calendar = new FullCalendar.Calendar(calendarEl, {} );
            //     calendar.render();
            // });
            document.addEventListener('livewire:load', function () {
                const Calendar = FullCalendar.Calendar;
                const calendarEl = document.getElementById('calendar');
                const calendar = new Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    locale: '{{ config('app.locale') }}',
                    events: JSON.parse(@this.events), 
                    editable: true,//On peut rendre les événements sur le calendrier modifiable
                    eventResize: info => @this.eventChange(info.event),
                    eventDrop: info => @this.eventChange(info.event), // Pour le drog and drop
                    selectable: true,
                    select: arg => {
                        const title = prompt('Titre :');
                        const id = create_UUID();
                        if (title) {
                            calendar.addEvent({
                                id: id,
                                title: title,   
                                start: arg.start,
                                end: arg.end,
                                allDay: arg.allDay
                            });
                            @this.eventAdd(calendar.getEventById(id));
                        };
                        calendar.unselect();
                    },
                    eventClick: info => { //suppresion d'un event
                        if (confirm("Voulez-vous vraiment supprimer cet événement ?")) {
                            info.event.remove();
                            @this.eventRemove(info.event.id);
                        }
                    },

                });
                const Draggable = FullCalendar.Draggable;
                    new Draggable(document.getElementById('events'), {
                        itemSelector: '.dropEvent'
                });
                calendar.render();
                console.log(Calendar);
            });
        </script>


    @endpush
</body>
</html>