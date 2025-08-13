<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatusPelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pelanggan jika belum membayar melebihi tenggat';

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
        $overdues = User::where('tenggat_bayar','<',Carbon::today()->subDays(90))->get();

        foreach ($overdues as $user){
            User::where('id',$user->id)->update(['status' => false]);
        }
    }
}
