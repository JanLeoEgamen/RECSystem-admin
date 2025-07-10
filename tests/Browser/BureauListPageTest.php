<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Bureau;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BureauListPageTest extends DuskTestCase
{
    public function test_bureau_actions_are_routable()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->first();
            $this->assertNotNull($user, 'Test user not found.');

            $bureau = Bureau::first();
            $this->assertNotNull($bureau, 'No bureau record found.');

            $browser->loginAs($user)
                ->visit('/bureaus')
                ->pause(1000)
                ->assertSee('Bureaus')

                ->visit('/bureaus/create')
                ->pause(1000)
                ->assertSee('Create')
                ->assertPathIs('/bureaus/create')

                ->visit("/bureaus/{$bureau->id}/edit")
                ->pause(1000)
                ->assertSee('Edit') 
                ->assertPathIs("/bureaus/{$bureau->id}/edit");
        });
    }
}
