<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;
use App\Models\Section;

class SectionListPageTest extends DuskTestCase
{
    public function test_section_actions_are_routable()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->first();
            $this->assertNotNull($user, 'Test user not found.');

            $section = Section::first();
            $this->assertNotNull($section, 'No section record found.');

            $browser->loginAs($user)
                ->visit('/sections')
                ->pause(1000)
                ->assertSee('Sections')

                ->visit('/sections/create')
                ->pause(1000)
                ->assertSee('Create')
                ->assertPathIs('/sections/create')
                
                ->visit("/sections/{$section->id}/edit")
                ->pause(1000)
                ->assertPathIs("/sections/{$section->id}/edit");
        });
    }
}
