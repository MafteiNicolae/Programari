@extends('dashboard')
@section('title', 'Programari')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="row">
                <div class="col-4 mt-3">
                    <div class="card mt-2 ms-5">
                        <h1 class="h2">Lista programari</h1>
                    </div>
                </div>
                <div class="col-5 mt-3">

                </div>
                <!-- <div class="col-3 mt-3">
                    <form action="#" method="POST">@csrf
                        <div class="d-flex align-items-center">
                        <div class=" btn btn-primary custom-file">
                            <input type="file" class="custom-file-input" name="file" id="customFile" style="display:none;">
                            <label  for="customFile" class="m-0">Alege csv</label>
                        </div>
                        <button type="submit" class=" btn btn-info ms-2">Salveaza</button>
                        </div>
                    </form>
                </div> -->
        </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 ms-5">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ziua</th>
                            <th>Ora</th>
                            <th>Sedinta</th>
                            <th>Profesor</th>
                            <th>Utilizator</th>
                            <th>Vizibilitate</th>
                            <th>Actiuni</th>
                        </tr>
                        @forelse($appointments as $key=>$appointment)
                            <tr>
                                <td>{{$appointments->firstItem() + $key }}</td>
                                <td>{{$appointment->dataa}}</td>
                                <td>{{$appointment->hour}}</td>
                                <td>{{$appointment->mitting}}</td>
                                <td>{{$appointment->teacher->name}}</td>
                                <td>
                                    @if($appointment->user != null)
                                        {{$appointment->user->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($appointment->visible == null)
                                        Nu
                                    @else
                                        Da
                                    @endif
                                </td>                                
                                <td>
                                    <a  class="btn btn-primary"
                                        href="{{route('appointments.create', ['appointment' => $appointment->id])}}"
                                        >
                                        Modifica
                                    </a>
                                    <button  class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteAppointmentModal_{{$appointment->id}}"

                                        id="delete"
                                        >
                                        Sterge
                                    </button>
                                </td>
                            </tr>
                            @include('appointment.deleteModal')
                        @empty
                        <tr>
                                <td colspan="8" class="text-center">
                                    <p>Momentan nu exista programari</p>
                                </td>
                            </tr>
                        @endforelse
                    </thead>
                </table>
                    {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection