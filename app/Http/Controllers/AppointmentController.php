<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;
use App\Mail\CancelMail;
use App\Mail\ChangeMail;
use App\Models\User;

class AppointmentController extends Controller
{
    public function create(Appointment $appointment = null){
        return view('appointment.create', compact('appointment'));
    }

    public function index(){
        $appointments = Appointment::paginate(10);
        return view('appointment.index', compact('appointments'));
    }

    public function indexClient(){

        $bla2= Appointment::where('user_id', Auth()->user()->id)->get();

        $blaArr = [];
        foreach($bla2 as $bla){
            $blaArr[] = $bla->mitting;
        }


        $appointmentClients = Appointment::where('dataa', '>=', Carbon::now())
                                         ->where('user_id', null)
                                         ->whereNotIn('mitting', $blaArr)
                                         ->orderBy('dataa', 'DESC')
                                         ->paginate(10);


        return view('appointment.client.index', compact('appointmentClients'));
    }

    public function myAppointment(){
        $myAppointments = Appointment::where('user_id', Auth()->user()->id)->orderBy('dataa', 'DESC')->paginate(10);
        return view('appointment.client.my', compact('myAppointments'));
    }

    public function updateClient(Request $request, Appointment $appointment){
        $appClient = Appointment::where('id', $appointment->id)->first();
        if($appClient->user_id){
            if($appClient->dataa < Carbon::now()) return redirect()->back();

            $appClient->update([
                'user_id' => null,
            ]);

            $day = $appointment->dataa;
            $hour = $appointment->hour;

            Mail::to(Auth()->user()->email)
                ->cc(ENV('OWNER_EMAIL'))
                ->send(new CancelMail(Auth()->user()->name, $day, $hour));

        }else{
            $appClient->update([
                'user_id' => Auth()->user()->id,
            ]);

            $day = $appointment->dataa;
            $hour = $appointment->hour;

            Mail::to(Auth()->user()->email)
                ->cc(ENV('OWNER_EMAIL'))
                ->send(new AppointmentMail(Auth()->user()->name, $day, $hour));
        }


        return redirect()->route('appointments.my');
    }

    public function store(AppointmentRequest $request, Appointment $appointment = null){
        $data = $request->validated();
        $data['visible'] = $request->has('visible');
        
        if($appointment != null){
            $oldApp = Appointment::findOrFail($appointment->id);

            $appointment->update([
                'dataa'         => $data['dataa'],
                'hour'          => $data['hour'],
                'mitting'       => $data['mitting'],
                'visible'       => $data['visible'],
                'user_id'       => $data['user_id'],
                'teacher_id'    => $data['teacher_id'],
            ]);

            if($appointment->user_id != $oldApp->user_id && $oldApp->user_id == null){
                Mail::to($appointment->user->email)
                ->cc(env('OWNER_EMAIL'))
                ->send(new AppointmentMail($appointment->user->name, $appointment->dataa, $appointment->hour));
            }elseif($appointment->user_id != $oldApp->user_id && $oldApp->user_id != null){
                Mail::to($oldApp->user->email)
                ->cc(env('OWNER_EMAIL'))
                ->send(new CancelMail($appointment->user->name, $appointment->dataa, $appointment->hour));
            }elseif($appointment->user_id == $oldApp->user_id && $oldApp->user_id != null){
                Mail::to($oldApp->user->email)
                ->cc(env('OWNER_EMAIL'))
                ->send(new ChangeMail($appointment->user->name, $appointment->dataa, $appointment->hour, $oldApp->dataa, $oldApp->hour));
            }

            $notification = array(
                'message' =>    'Programare modificata cu succes!',
                'alert-type'    => 'success',
            );

        }else{
            $newApp = Appointment::create([
                'dataa'         => $data['dataa'],
                'hour'          => $data['hour'],
                'mitting'       => $data['mitting'],
                'visible'       => $data['visible'],
                'user_id'       => $data['user_id'],
                'teacher_id'    => $data['teacher_id'],
            ]);

            if($newApp->user_id != null){
                $user = User::where('id', $newApp->user_id)->first();
                $day = $newApp->dataa;
                $hour = $newApp->hour;

                Mail::to($user->email)
                ->cc(ENV('OWNER_EMAIL'))
                ->send(new AppointmentMail($user->name, $day, $hour));
            }

            $notification = array(
                'message' =>    'Programare inregistrat cu succes!',
                'alert-type'    => 'success',
            );
        }

        return redirect()->route('appointments.index')->with($notification);
    }

    public function delete(Appointment $appointment){
        $appointment->delete();

        $notification = array(
            'message' =>    'Programare stearsa cu succes!',
            'alert-type'    => 'success',
        );

        return redirect()->route('appointments.index')->with($notification);
    }

    public function search(Request $request){
        $search = $request->search2;
        $appointmentClients = Appointment::whereHas('teacher', function($query) use($search){
                                                $query->where('name', 'LIKE', '%' . $search . '%');
                                                })
                                         ->orWhereDate('dataa', $search)
                                         ->paginate(10);

        $appointmentClients->appends(array(
            'search' => $request->search2,
        ));
        return view('appointment.client.index', compact('appointmentClients', 'search'));
    }
}
