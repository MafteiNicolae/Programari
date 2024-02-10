@extends('dashboard')
@section('title', 'Programari')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Adauga programare</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('appointments.store', ['appointment' => $appointment?->id])}}"> @csrf
                    <div class="row mb-3">
                        <label for="name-input" class="col-sm-2 col-form-label">Ziua</label>
                        <div class="col-sm-10">
                            <input class="form-control {{ $errors->has('dataa') ? 'is-invalid' : '' }}"
                                   name="dataa"
                                   value="{{ old('dataa') ?? $appointment?->dataa }}"
                                   type="date"
                                   id="data-input"
                            />

                            <span class="error invalid-feedback">
                                @if ($errors->has('data'))
                                    <p>{{ $errors->first('data') }}</p>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email-input" class="col-sm-2 col-form-label">Ora</label>
                        <div class="col-sm-10">
                            <input class="form-control {{ $errors->has('hour') ? 'is-invalid' : '' }}"
                                   name="hour"
                                   value="{{old('hour') ?? $appointment?->hour }}"
                                   type="text"
                                   placeholder="09:30"
                                   id="hour-input"
                            />

                            <span class="error invalid-feedback">
                                @if ($errors->has('hour'))
                                    <p>{{ $errors->first('hour') }}</p>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email-input" class="col-sm-2 col-form-label">Sedinta</label>
                        <div class="col-sm-10">
                            <input class="form-control {{ $errors->has('mitting') ? 'is-invalid' : '' }}"
                                   name="mitting"
                                   value="{{old('mitting') ?? $appointment?->mitting }}"
                                   type="number"
                                   placeholder="1"
                                   id="mitting-input"
                            />

                            <span class="error invalid-feedback">
                                @if ($errors->has('mitting'))
                                    <p>{{ $errors->first('mitting') }}</p>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="visible-input" class="col-sm-2 col-form-label">Vizualizare</label>
                        <div class="col-sm-10">
                            <input class="form-check"
                                   name="visible"
                                   type="checkbox"

                                   {{ old('visible', $appointment?->visible) == 1 ? 'checked' : '' }}
                                   id="visible-input"
                            />
                           
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role-input" class="col-sm-2 col-form-label">Profesor</label>
                        <div class="col-sm-10">
                            <select name="teacher_id" class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}">
                                <option value="" >---- Alege profesor -----</option>
                                @foreach(App\Models\Teacher::all() as $teacher)
                                    <option value="{{$teacher->id}}" {{ old('teacher_id', $appointment?->teacher_id) == $teacher->id ? 'selected' : ""}}>{{$teacher->name}}</option>
                                @endforeach
                            </select>

                            <span class="error invalid-feedback">
                                @if ($errors->has('teacher_id'))
                                    <p>{{ $errors->first('teacher_id') }}</p>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role-input" class="col-sm-2 col-form-label">Student</label>
                        <div class="col-sm-10">
                            <select name="user_id" class="form-control">
                                <option value="" >---- Alege utilizator -----</option>
                                @foreach(App\Models\User::where('is_admin', 0)->get() as $user)
                                    <option value="{{$user->id}}" {{ old('user_id', $appointment?->user_id) == $user->id ? 'selected' : ""}}>{{$user->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <button class="btn btn-success" type="submit">Salveaza</button>
                    <a class="btn btn-secondary" href="{{route('appointments.index')}}">Inapoi</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection