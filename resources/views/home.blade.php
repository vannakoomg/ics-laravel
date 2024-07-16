@extends('layouts.admin')
<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        background-color: #007bff;
        color: #FFF;
        height: 150px;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
        height: 150px;
    }

    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
        height: 150px;
    }

    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 40px;
        font-size: 40px;
        display: block;
    }

    .card-counter .count-small {
        position: absolute;
        right: 35px;
        top: 10px;
        font-size: 23px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 100px;
        /* font-style: italic; */
        /* text-transform: capitalize; */
        opacity: 0.8;
        display: block;
        font-size: 18px;
    }
</style>
@section('content')



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="container-fluid pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-counter primary">
                                <i class="fa fa-home " style="color: white; padding: 10pt;"></i>
                                <span class="count-numbers">{{ $firebaseToken }}</span>
                                <span class="count-name">App Downloaded on Device</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.home.show', ['CC']) }}">
                                <div class="card-counter danger">
                                    <i class="fa fa-user" style="color: white; padding: 10pt;"></i>
                                    <span class="count-small">
                                        CC
                                    </span>
                                    <span class="count-numbers">
                                        {{ $userCCNo }}
                                        {{-- <div class="row">
                                            <div class="col-9 ">.col-9</div>
                                            <div class="col-9">sadfsafdadsfsadf </div>
                                        </div> --}}
                                    </span>
                                    <span class="count-name">Not Signed In</span>
                                </div>
                            </a>

                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('admin.home.show', ['MC']) }}">
                                <div class="card-counter success"style="color: white; padding: 10pt;">
                                    <i class="fa fa-user " style="color: white; padding: 10pt;"></i>
                                    <span class="count-small">
                                        MC
                                    </span>
                                    <span class="count-numbers">{{ $userMCNo }}</span>
                                    <span class="count-name">Not Signed In</span>
                                </div>
                            </a>

                        </div>

                    </div>
                </div>





                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- You are logged in! --}}
                @if (auth()->user()->is_teacher)
                    <div class="row">
                        <div class="col-lg">
                            <div class="card">

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item active"><strong>School Class Information</strong>
                                    </li>
                                    @foreach ($classes as $class)
                                        <li class="list-group-item">{{ $class->name }} <span
                                                class="badge badge-primary">{{ $class->campus }}</span> => Total
                                            Students <span
                                                class="badge badge-success">{{ $class->classUsers->count() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item active"><strong>Assignment Information</strong></li>
                                    {{-- <li class="list-group-item">Unpublish Assignment: <span class="badge badge badge-warning">44</span>  Published Assignment <span class="badge badge-primary">99</span></li>
                                <li class="list-group-item"> --}}
                                    </li>
                                </ul>
                                <div class="accordion" id="accordionExample">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Unpublish Assignment <span
                                                        class="badge badge-warning">{{ count($data['unpublish']) }}</span>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    @foreach ($data['unpublish'] as $n => $d)
                                                        <li class="list-group-item">{{ $n + 1 }}-
                                                            {{ $d->course->name }}: {{ $d->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-0">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    Published Assignment <span
                                                        class="badge badge-primary">{{ count($data['publish']) }}</span>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    @foreach ($data['publish'] as $n => $d)
                                                        <li class="list-group-item">{{ $n + 1 }}-
                                                            {{ $d->course->name }}: {{ $d->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                </li>
                                </ul>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item active"><strong>Student Submitted Assignment</strong>
                                    </li>
                                    <li class="list-group-item">

                                        <table class="table table-sm display">
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Student Name</td>
                                                    <td>Assignment</td>
                                                    <td>Class</td>
                                                    <td>Campus</td>
                                                    <td>Submitted Date</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assign_returns as $no => $assignment)
                                                    <tr>
                                                        <td>{{ $no + 1 }}</td>
                                                        <td>{{ $assignment->student->name }}</td>
                                                        <td>{{ $assignment->homework->name }}</td>
                                                        <td>{{ $assignment->student->class->name }}</td>
                                                        <td>{{ $assignment->student->class->campus }}</td>
                                                        <td>{{ $assignment->turnedindate->format('d-m-Y h:i A') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
