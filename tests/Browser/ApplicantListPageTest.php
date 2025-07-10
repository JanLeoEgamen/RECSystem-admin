<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Applicant;

class ApplicantListPageTest extends DuskTestCase
{
    public function test_applicant_actions_are_routable()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->first();
            $this->assertNotNull($user, 'Test user not found.');

            $applicant = Applicant::first();
            $this->assertNotNull($applicant, 'No applicant record found.');

            $browser->loginAs($user)
                ->visit('/applicants')
                ->pause(1000)
                ->assertSee('Applicants')

                ->click('@go-to-rejected')
                ->pause(1000)
                ->assertPathIs('/applicants/rejected/list')

                ->visit('/applicants')
                ->click('@go-to-approved')
                ->pause(1000)
                ->assertPathIs('/applicants/approved/list')

                ->visit("/applicants/{$applicant->id}")
                ->pause(1000)

                ->assertPathIs("/applicants/{$applicant->id}")

                ->visit("/applicants/{$applicant->id}/edit")
                ->pause(1000)
                ->assertPathIs("/applicants/{$applicant->id}/edit")

                ->visit("/applicants/{$applicant->id}/assess")
                ->pause(1000)
                ->assertPathIs("/applicants/{$applicant->id}/assess");
        });
    }
}
