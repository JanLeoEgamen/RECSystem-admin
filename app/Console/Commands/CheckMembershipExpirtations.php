<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MembershipExpirationService;

class CheckMembershipExpirations extends Command
{
    protected $signature = 'membership:check-expirations';
    protected $description = 'Check for expiring memberships and send notifications';

    public function handle()
    {
        $service = new MembershipExpirationService();
        $service->checkExpiringMemberships();
        
        $this->info('Membership expiration check completed.');
    }
}