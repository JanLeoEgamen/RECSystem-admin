<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MembershipTypeListPageTest extends DuskTestCase
{
    public function test_membership_type_list_and_create_page_loads()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->firstOrFail();

            $browser->loginAs($user)

                ->visit('/membership-types')
                ->pause(1000)
                ->assertSee('Membership Types')
                ->assertPathIs('/membership-types')

                ->visit('/membership-types/create')
                ->pause(1000)
                ->assertSee('Create')
                ->assertPathIs('/membership-types/create')

                ->visit('/membership-types')
                ->pause(1000)
                ->assertSee('Membership Types')
                ->assertPathIs('/membership-types');
        });
    }
}
