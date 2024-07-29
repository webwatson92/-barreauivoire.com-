@extends('layouts.base2')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css' rel='stylesheet' />
    <style>
        #calendar-container {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 20px;
        }
        #events {
            grid-column: 1;
        }
        #calendar {
            grid-column: 2;
            height: 700px;
        }
        .dropEvent {
            background-color: DodgerBlue;
            color: white;
            padding: 5px 16px;
            margin-bottom: 10px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="eventModalLabel">Ajouter un évènement</h1>
                    @if(Session::get('success'))
                        <div class="p-5">
                            <div class="block p-2 bg-green-500 text-white rounded-sm shadow-sm mt-2">{{ Session::get('success') }}</div>
                        </div>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <input type="hidden" id="eventId">
                    <div class="modal-body">
                        <label for="title" class="col-form-label">Titre</label>
                        <input type="text" placeholder="Entrer le titre" name="title" class="form-control" required id="title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div>
                            <label for="is_all_day" class="col-form-label">Toute la journée</label>
                            <input type="checkbox" checked required class="form-control" name="in_all_day" id="is_all_day">
                            @error('is_all_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="startDateTime" class="col-form-label">Date/Heure Début</label>
                        <input type="text" placeholder="Date Début" name="start" required class="form-control" id="startDateTime">
                        @error('start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="endDateTime" class="col-form-label">Date/Heure Fin</label>
                        <input type="text" placeholder="Date Fin" name="end" required class="form-control" id="endDateTime">
                        @error('end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <label for="description" class="col-form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Décrivez votre évènement..."  id="description" required></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="button" onclick="onSubmitFormData()" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script> 
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script>
        // var moment = require('moment');
        // console.log(moment().format());

        var calendar = null;
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: '{{ route("refresh-events") }}',
                locale: '{{ config('app.locale') }}',
                editable: true,
                selectable: true,
                dateClick: function(info) {
                    let startDate, endDate, allDay;
                    allDay = $('#is_all_day').prop('checked');
                    if(allDay){
                        // startDate = moment(info.date).format('YYYY-MM-DD');
                        // endDate = moment(info.date).format('YYYY-MM-DD');
                        initializeStartDateEndDateFormat('Y-MM-DD', true);
                    }else{
                        // startDate = moment(info.date).format('YYYY-MM-DD HH:mm:ss');
                        // endDate = moment(info.date).add(30, 'minutes').format('YYYY-MM-DD HH:mm:ss');
                        initializeStartDateEndDateFormat('Y-MM-DD HH:mm:ss', false);
                    }
                    $('#startDateTime').val(startDate);
                    $('#endDateTime').val(endDate);
                    $('#eventModal').modal('show');
                }, 
                eventClick: function (info){
                    modalReset();
                    $('#eventModal').modal('show');
                    const event = info.event;
                    $('#title').val(event.title);
                    $('#eventId').val(info.event.title);
                    $('#description').val(event.extendedProps.description);
                    $('#startDateTime').val(event.extendedProps.startDay);
                    $('#endDateTime').val(event.extendedProps.endDay);
                    $('#is_all_day').val('checked', event.allDay);
                    $('#eventModal').modal('show');

                    console.log(info);
                    if(info.event.allDay){
                        initializeStartDateEndDateFormat('Y-MM-DD', true);
                    }else{
                        initializeStartDateEndDateFormat('Y-MM-DD H:i', false);
                    }
                }
            });

            calendar.render();

            $('#is_all_day').change(function() {
                let is_all_day = $(this).prop('checked');
                if (is_all_day) {
                    let start = $('#startDateTime').val().slice(0, 10);
                    $('#startDateTime').val(start);
                    let endDateTime = $('#endDateTime').val().slice(0, 10);
                    $('#endDateTime').val(endDateTime);
                    initializeStartDateEndDateFormat('Y-MM-DD', is_all_day);
                } else {
                    let start = $('#startDateTime').val().slice(0, 10);
                    $('#startDateTime').val(start + " 00:00");
                    let endDateTime = $('#endDateTime').val().slice(0, 10);
                    $('#endDateTime').val(endDateTime + " 00:30");
                    initializeStartDateEndDateFormat('Y-MM-DD HH:mm:ss', is_all_day);
                }
            })
        });
}

        function onSubmitFormData(){
            let eventId = $('#eventId').val();
            console.log("eventId="+eventId);
            let url = "{{ route('evenements.store') }}";
            let postData = {
                start : $('#startDateTime').val(),
                end : $('#endDateTime').val(),
                title : $('#title').val(),
                description : $('#description').val(),
                is_all_day : $('#is_all_day').prop('checked') ? 1 : 0
            };
            if(postData.is_all_day){
                //postData.end = moment().add(1. "days").format('YYYY-MM-DD');
            }
            if(eventId){
                url = "{{  url('/')}} + '/events/${eventId}";
                postData.method = "PUT";
            }
            
            $.ajax({
                type: "POST",
                url: url,
                dataType : "json",
                data: postData,
                success: function (result) {
                    if(result.success){
                        calendar.refetchEvents();
                        $('#eventModal').modal('hide');
                        modalReset();
                    }else{
                        alert("Something going wrong!!");
                    }
                }
            });
        }

        function initializeStartDateEndDateFormat(format, allDay) {
            let timePicker = !allDay;
            $('#startDateTime').datetimepicker({
                format: format,
                timepicker: timePicker
            });
            $('#endDateTime').datetimepicker({
                format: format,
                timepicker: timePicker
            });
        }

        function modalReset(){
            $('title').val('');
            $('description').val('');
            $('startDateTime').val('');
            $('endDateTime').val('');
        }

    </script> 
@endpush
