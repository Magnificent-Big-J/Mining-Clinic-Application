<?php


namespace App\Service;


use App\Models\Appointment;
use Carbon\Carbon;

class BookingService
{
        public static function timeSlots() : array
        {
            return [
                    '08:00',
                    '08:30',
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '12:00',
                    '12:30',
                    '13:00',
                    '14:00',
                    '15:00',
                    '15:30',
                    '16:00',
                    '16:30',
                    '17:00'
            ];
        }
        public static function alreadyBooked(string $appointment, string $time, int $doctor) :bool
        {
            $appointment = Appointment::where('doctor_id', '=', $doctor)
                ->where('appointment_time', '=', $time)
                ->where('appointment_date', '=', Carbon::parse($appointment))
                ->first();

            if ($appointment) {
                return true;
            }
            return false;
        }
}
