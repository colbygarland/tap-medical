<?php

namespace App\Console\Commands;

use App\Appointment;
use Http;
use Illuminate\Console\Command;

class PullAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull appointments into the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Appointment::clinicOne();
        return 0;
    }
}
