<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomePageTest extends DuskTestCase
{
    public function testWelcomePageDisplaysCorrectly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/welcome')
                ->pause(3000)
                ->screenshot('welcome-debug')
                ->assertTitle('REC Inc. Admin')
                ->assertVisible('header .logo img')
                ->assertSee('RADIO ENGINEERING CIRCLE INC.')
                ->assertSee('Welcome to REC Inc. Portal')
                ->assertSee('Connecting radio enthusiasts')
                ->assertSee('Visit RECInc. Website')
                ->assertSee('Amateur Radio Club');

            if ($browser->element('a[href="/login"]')) {
                $browser->assertSee('Login');
            }

            if ($browser->element('a[href="/register"]')) {
                $browser->assertSee('Register');
            }
        });
    }
}
