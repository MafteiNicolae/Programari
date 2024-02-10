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
                            <th>Anuleaza</th>
                        </tr>
                        @forelse($myAppointments as $key=>$myAppointment)
                            <tr>
                                <td>{{$myAppointments->firstItem() + $key }}</td>
                                <td>{{$myAppointment->dataa}}</td>
                                <td>{{$myAppointment->hour}}</td>
                                <td>
                                    @if(Carbon\Carbon::now() <= $myAppointment->dataa )
                                        <form method="POST" action="{{route('appointments.updateClient', ['appointment' => $myAppointment->id])}}">@csrf
                                            <input type="hidden" value="{{$myAppointment->id}}" name="appointmenth">
                                            <button type="submit" class="btn btn-danger">Anuleza</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Sedinta efectuata</span>
                                    @endif
                                </td>                          
                            </tr>
                        @empty
                        <tr>
                                <td colspan="8" class="text-center">
                                    <p>Momentan nu exista programari disponibile</p>
                                </td>
                            </tr>
                        @endforelse
                    </thead>
                </table>
                    {{ $myAppointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection