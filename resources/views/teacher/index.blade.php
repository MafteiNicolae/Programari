@extends('dashboard')
@section('title', 'Profesori')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="row">
                <div class="col-4 mt-3">
                    <div class="card mt-2 ms-5">
                        <h1 class="h2">Lista profesori</h1>
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
                            <th>Nume</th>
                            <th >Actiuni</th>
                        </tr>
                        @forelse($teachers as $key=>$teacher)
                            <tr>
                                <td>{{$teachers->firstItem() + $key }}</td>
                                <td>{{$teacher->name}}</td>
                            
                                <td>
                                    <a  class="btn btn-primary"
                                        href="{{route('teachers.add-edit', $teacher->id)}}"
                                        >
                                        Modifica
                                    </a>
                                    <button  class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteTeacherModal_{{$teacher->id}}"

                                        id="delete"
                                        >
                                        Sterge
                                    </button>
                                </td>
                            </tr>
                        @include('teacher.deleteModal')
                        @empty
                        <tr>
                                <td colspan="8" class="text-center">
                                    <p>Momentan nu exista profesori inregistrati</p>
                                </td>
                            </tr>
                        @endforelse
                    </thead>
                </table>
                    {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection