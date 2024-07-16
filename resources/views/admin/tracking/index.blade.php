@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Track When User Click On Menu
        </div>
        <div class="card-body">
            <div class="container-fluid text-center">
                <div class="row align-items-start">
                    <form action="{{ route('admin.tracking.index') }}">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group text-left">
                                    <label class="required" for="from_date">From Date </label>
                                    <input id="from_date" name="from_date" type="text"
                                        class="form-control datetimepicker {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        value="{{ $fromDate }}" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group text-left">
                                    <label for="end_date" class="required">End Date </label>
                                    <input id="end_date" name="end_date" type="text"
                                        class="form-control datetimepicker {{ $errors->has('name') ? 'is-invalid' : '' }}",
                                        value="{{ $endDate }}" required>
                                </div>
                            </div>
                            <div class="col-1">
                                <label for="end_date">Search </label>
                                <button class="btn btn-success " type="submit" class="form-control">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="col-8">
                        <canvas id="chart"></canvas>
                    </div>
                    @if ($chart['mc'] != 0 || $chart['cc'] != 0)
                        <div class="col-4 align-self-center">
                            Summary
                            <canvas id="chartPie" class=""></canvas>
                        </div>
                    @endif


                </div>
            </div>

            <div class="table-responsive">

                <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-SchoolClass">
                    <thead>
                        <tr>
                            <th width="10">
                            </th>
                            <th>
                                Student ID
                            </th>
                            <th>
                                Student Name
                            </th>
                            <th>
                                Menu Name
                            </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($track as $key => $trackee)
                            <tr data-entry-id="{{ $trackee->id }}">
                                <td>
                                </td>
                                <td>
                                    {{ $trackee->user_name ?? '' }}
                                </td>
                                <td>
                                    {{ $trackee->name ?? '' }}
                                </td>
                                <td>
                                    {{ $trackee->menu_name ?? '' }}
                                </td>
                                <td>
                                    {{ $trackee->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
        <script>
            const pie = document.getElementById("chartPie").getContext('2d');
            const chartPie = new Chart(pie, {
                type: 'pie',
                data: {
                    labels: ["MC:  {{ $chart['mc'] }}", "CC :  {{ $chart['cc'] }}"],
                    datasets: [{
                        backgroundColor: [
                            'rgba(134, 39, 39, 1)',
                            'rgba(49, 150, 54, 1)',
                        ],
                        borderColor: 'rgba(134, 39, 39, 1)',
                        data: [{{ $chart['mc'] }}, {{ $chart['cc'] }}],
                    }]
                },
            });
        </script>
        <script>
            const ctx = document.getElementById("chart").getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        "News", "Attendance", "Timetable", "Exam Schedule",
                        "Report Card", "Events", "Gallery", "Assignments",
                        "Assignment Results", "Pick Up", "E-Learning",
                        "Feedback", "Canteen", "Contact Us", "About Us", "Profile", "Notification"
                    ],
                    datasets: [{
                        label: 'Click',
                        backgroundColor: [
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',
                            'rgba(41, 120, 224, 1)',
                            'rgba(226, 92, 40, 1)',

                        ],
                        borderColor: 'rgb(47, 128, 237)',
                        data: [
                            {{ $chart['announcement'] }} ?? 1,
                            {{ $chart['attendance_calendar'] }},
                            {{ $chart['timetable'] }},
                            {{ $chart['exam_schedule'] }},
                            {{ $chart['student_report'] }},
                            {{ $chart['events'] }},
                            {{ $chart['gallary'] }},
                            {{ $chart['homeworks'] }},
                            {{ $chart['class_results'] }},
                            {{ $chart['pick_up_card'] }},
                            {{ $chart['e_learning'] }},
                            {{ $chart['feedback'] }},
                            {{ $chart['canteen'] }},
                            {{ $chart['contact us'] }},

                            {{ $chart['about us'] }},
                            {{ $chart['profile'] }},
                            {{ $chart['notification'] }},

                        ],
                    }]
                },
                options: {

                    legend: {
                        display: false,

                    },
                    scales: {
                        yAxes: [{
                            ticks: {

                                beginAtZero: true,
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                maxRotation: 90, // Rotate labels by 90 degrees
                                minRotation: 0, // Reset rotation angle
                            }
                        }],
                    }

                },
            });
        </script>
    </div>
@endsection
@section('scripts')
    @parent

    <script>
        $(function() {
            $('input[type="checkbox"]').on("change", function() {
                $('#form1').submit();
            });
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            $.extend(true, $.fn.dataTable.defaults, {
                pageLength: 30,
            });
            $('.datatable-SchoolClass:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $(function() {
                $('.datetimepicker').datetimepicker({
                    format: 'YYYY/MM/DD'
                });
            });

        })
    </script>
@endsection
