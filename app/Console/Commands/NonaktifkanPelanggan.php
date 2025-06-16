<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pelanggan;

class NonaktifkanPelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:nonaktifkan-pelanggan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tanggalBatas = now()->subDays(30);

        Pelanggan::where('status_id', 1)
            ->whereDate('tanggal_berlangganan', '<=', $tanggalBatas)
            ->update(['status_id' => 2]);
    }

}
