<?php

namespace App\Console\Commands;

use App\Mail\LastLoginMailable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:taskemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send custom emails';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = new LastLoginMailable;
        $messageSend = Mail::to('andrs3662@gmail.com')->send($email);
    }
}
