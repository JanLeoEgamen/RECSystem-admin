<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    public function testLoginPageLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->pause(1000)
                    ->assertTitleContains('Login')
                    ->pause(1000)
                    ->assertSee('Welcome Back, Admin')
                    ->pause(1000)
                    ->assertVisible('@password-input')
                    ->pause(1000)
                    ->assertVisible('@password-toggle')
                    ->pause(1000)
                    ->assertVisible('@login-button')
                    ->pause(1000);
        });
    }

    public function testLoginFormValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->pause(1000)
                    ->type('email', 'invalid@example.com')
                    ->pause(1000)
                    ->type('password', 'wrongpassword')
                    ->pause(1000)
                    ->click('@login-button')
                    ->pause(2000)
                    ->assertPathIs('/login');
        });
    }

    public function testSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->pause(1000)
                    ->type('email', 'janleoegamen6@gmail.com')
                    ->pause(1000)
                    ->type('password', 'admin123')
                    ->pause(1000)
                    ->click('@login-button')
                    ->pause(3000)
                    ->assertPathIs('/dashboard');
        });
    }
}
