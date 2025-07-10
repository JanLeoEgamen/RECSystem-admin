<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTestPage extends DuskTestCase
{
    /** @test */
    public function dashboard_page_displays_correctly()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'janleoegamen6@gmail.com')->first(); // Update as needed

            $browser->loginAs($admin)
                    ->visit('/dashboard')
                    ->pause(1500)
                    ->assertSee('Dashboard')
                    ->assertSee('Hello,')
                    ->assertSee("You're logged in!")
                    ->assertSee('Total Members')
                    ->assertSee('Active Members')
                    ->assertSee('Memberships Expiring Soon')
                    ->screenshot('dashboard-full-view');
        });
    }

    /** @test */
    public function quick_action_buttons_are_visible()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'janleoegamen6@gmail.com')->first();

            $browser->loginAs($admin)
                    ->visit('/dashboard')
                    ->pause(1000)
                    ->assertSee('Membership Management Quick Actions')
                    ->assertSee('New Applicant')
                    ->assertSee('New Member')
                    ->assertSee('Assess Applicants')
                    ->assertSee('Renew Members')
                    ->assertSee('Website Content Management Quick Actions')
                    ->assertSee('New Event')
                    ->assertSee('New Article')
                    ->assertSee('New Community')
                    ->assertSee('New Carousel')
                    ->assertSee('New Supporter')
                    ->assertSee('Maintenance Quick Actions')
                    ->assertSee('New Bureau')
                    ->assertSee('New Role')
                    ->assertSee('New Permission')
                    ->screenshot('dashboard-quick-actions');
        });
    }
}
