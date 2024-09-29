<?php

namespace App\Console\Commands;

use App\Mail\ReservationReminder;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for reservations nearing their due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $reservations = Reservation::where('reminder_sent', false)
            ->whereDate('reservation_date', '<=', Carbon::now()->toDateString())
            ->get();

        foreach ($reservations as $reservation) {
            $reservationEndDate = Carbon::parse($reservation->reservation_date)->addDays($reservation->duration);

            // Check if the reservation is due in 1 day
            if (Carbon::now()->diffInDays($reservationEndDate) == 6) {
                // Send the reminder email
                Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));

                // Mark the reservation as having received a reminder
                $reservation->reminder_sent = true; // Modifie l'attribut
                $reservation->save();

                $this->info('Reminder sent for reservation ID: ' . $reservation->id);
            }
        }
    }
}
