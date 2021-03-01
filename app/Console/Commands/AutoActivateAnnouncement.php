<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use Illuminate\Console\Command;

class AutoActivateAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcement:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auotomatically activate/deactivate announcement based on given start and end date';

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

        try {
            $model = app(Announcement::class);
            $model->autoActivateAndDeactivate();
        } catch (\Exception $e) {
            
        }

        return 0;
    }
}
