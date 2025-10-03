<?php

namespace App\Jobs;

use App\Services\OtpService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $phone;
    protected string $code;

    public function __construct(string $phone, string $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    public function handle(OtpService $service)
    {
        $service->sendSmsNow($this->phone, $this->code);
    }
}
