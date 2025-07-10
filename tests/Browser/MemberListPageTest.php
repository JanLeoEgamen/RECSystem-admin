<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Member;

class MemberListPageTest extends DuskTestCase
{
    public function test_member_actions_are_routable()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->first();
            $this->assertNotNull($user, 'Test user not found. Please ensure janleoegamen6@gmail.com exists in the users table.');

            $member = Member::first();
            $this->assertNotNull($member, 'No member record found in the database.');

            $browser->loginAs($user)
                ->visit('/members')
                ->pause(1000)
                ->assertSee('Members')

                ->click('@go-to-active')
                ->pause(1000)
                ->assertPathIs('/members/active')

                ->visit('/members') 
                ->click('@go-to-inactive')
                ->pause(1000)
                ->assertPathIs('/members/inactive')

                ->visit('/members')

                ->visit("/members/{$member->id}")
                ->pause(1000)
                ->assertPathIs("/members/{$member->id}")

                ->visit("/members/{$member->id}/edit")
                ->pause(1000)
                ->assertPathIs("/members/{$member->id}/edit")

                ->visit("/members/{$member->id}/renew")
                ->pause(1000)
                ->assertPathIs("/members/{$member->id}/renew");
        });
    }
}
