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
                <div class="col-3 mt-3">
                    <form action="{{route('appointments.search')}}" method="POST">@csrf
                        <!-- <div class="d-flex align-items-center"> -->
                        <!-- <div class=" btn btn-primary custom-file"> -->
                            <input type="text" class="custom-file-input" name="search2" placeholder="Cauta" value="{{ $search ?? null }}">
                            <button type="submit" class=" btn btn-info ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <!-- </div> -->
                    </form>
                </div>
        </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0 ms-5">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ziua</th>
                            <th>Ora</th>
                            <th>Profesor</th>
                            <th>Rezerva</th>
                        </tr>
                        @forelse($appointmentClients as $key=>$appointmentClient)
                            <tr>
                                <td>{{$appointmentClients->firstItem() + $key }}</td>
                                <td>{{$appointmentClient->dataa}}</td>
                                <td>{{$appointmentClient->hour}}</td>
                                <th>{{$appointmentClient->teacher->name}}</th>
                                <td>
                                    <form method="POST" action="{{route('appointments.updateClient', ['appointment' => $appointmentClient->id])}}">@csrf
                                        <input type="hidden" value="{{$appointmentClient->id}}" name="appointmenth">
                                        <button type="submit" class="btn btn-primary">Rezerva</button>
                                    </form>
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
                    {{ $appointmentClients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection