<?php

namespace App\Services;

use App\Exceptions\AppointmentException;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Notifications\AppointmentConfirmedNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    public function create(array $data): Appointment
    {
        $appointmentDate = Carbon::parse($data['appointment_date']);
        /*
        |--------------------------------------------------------------------------
        | Rule 1: Prevent booking in the past
        |--------------------------------------------------------------------------
        */
        if ($appointmentDate->isPast()) {
            throw new AppointmentException(
                'Cannot book appointment in the past.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 2: Doctor must work on this day
        |--------------------------------------------------------------------------
        */
        $day = strtolower($appointmentDate->format('l'));

        $schedule = DoctorSchedule::where('doctor_id',$data['doctor_id'])->where('clinic_id',$data['clinic_id'])
        ->where('day',$day)->first();
        if (!$schedule) {
            throw new AppointmentException(
                'Doctor is not available on this day.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 3: Appointment must be inside working hours
        |--------------------------------------------------------------------------
        */
        $appointmentTime =
            $appointmentDate->format('H:i:s');

        if (
            $appointmentTime < $schedule->start_time ||
            $appointmentTime > $schedule->end_time
        ) {
            throw new AppointmentException(
                'Appointment is outside working hours.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 4: Prevent duplicate appointments
        |--------------------------------------------------------------------------
        */
        $exists = Appointment::where(
            'doctor_id',
            $data['doctor_id']
        )
        ->where(
            'appointment_date',
            $data['appointment_date']
        )
        ->exists();

        if ($exists) {
           throw new AppointmentException(
                'This appointment time is already booked.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Appointment
        |--------------------------------------------------------------------------
        */
        $appointment = Appointment::create($data);

        /*
        |--------------------------------------------------------------------------
        | Log
        |--------------------------------------------------------------------------
        */
        Log::info(
            'Appointment created successfully',
            [
                'appointment_id' => $appointment->id,
                'doctor_id' => $appointment->doctor_id,
            ]
        );

        return $appointment;
    }

        public function update(Appointment $appointment,array $data): Appointment {

        $appointmentDate = Carbon::parse(
            $data['appointment_date']
        );

        /*
        |--------------------------------------------------------------------------
        | Rule 1: Prevent booking in the past
        |--------------------------------------------------------------------------
        */
        if ($appointmentDate->isPast()) {
            throw new AppointmentException(
                'Cannot book appointment in the past.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 2: Doctor must work on this day
        |--------------------------------------------------------------------------
        */
        $day = $appointmentDate->format('l');

        $schedule = DoctorSchedule::where(
            'doctor_id',
            $data['doctor_id']
        )
        ->where(
            'clinic_id',
            $data['clinic_id']
        )
        ->where(
            'day',
            $day
        )
        ->first();

        if (!$schedule) {
            throw new AppointmentException(
                'Doctor is not available on this day.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 3: Inside working hours
        |--------------------------------------------------------------------------
        */
        $appointmentTime =
            $appointmentDate->format('H:i:s');

        if (
            $appointmentTime < $schedule->start_time ||
            $appointmentTime > $schedule->end_time
        ) {
            throw new AppointmentException(
                'Appointment is outside working hours.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rule 4: Prevent duplicate appointments
        |--------------------------------------------------------------------------
        */
        $exists = Appointment::where(
            'doctor_id',
            $data['doctor_id']
        )
        ->where(
            'appointment_date',
            $data['appointment_date']
        )
        ->where(
            'id',
            '!=',
            $appointment->id
        )
        ->exists();

        if ($exists) {
            throw new AppointmentException(
                'This appointment time is already booked.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Appointment
        |--------------------------------------------------------------------------
        */
        $appointment->update($data);

        Log::info(
            'Appointment updated successfully',
            [
                'appointment_id' => $appointment->id,
            ]
        );

        return $appointment->fresh();
    }

    // confirm the appointment
    public function confirm(Appointment $appointment): Appointment {
        //business rules
        if ($appointment->status!== "pending") {
            throw new AppointmentException(
                'Only pending appointments can be confirmed.'
            );
        }
        $appointment->update(['status' =>"confirmed"]);
        $appointment->user->notify(new AppointmentConfirmedNotification($appointment));
        return $appointment->fresh();
    }

    // complate the appointment
        public function complete(
        Appointment $appointment
    )
    {
        if (
            $appointment->status !== 'confirmed'
        ) {
            throw new AppointmentException(
                'Only confirmed appointments can be completed.'
            );
        }

        $appointment->update([
            'status' => 'completed'
        ]);

    return $appointment->fresh();
    }
    // cancel the appointment
        public function cancel(
        Appointment $appointment
    ): Appointment {

        if (
            $appointment->status
            === "completed"
        ) {
            throw new AppointmentException(
                'Completed appointments cannot be cancelled.'
            );
        }

        $appointment->update([
            'status' =>
            "cancelled"
        ]);

        return $appointment->fresh();
    }
}