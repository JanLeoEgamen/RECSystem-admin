<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterPageTest extends DuskTestCase
{
    /** @test */
    public function register_page_loads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->pause(1000)
                ->assertSee('Create Your Account')
                ->pause(1000)
                ->assertSee('First Name')
                ->pause(1000)
                ->assertSee('Last Name')
                ->pause(1000)
                ->assertSee('Birthdate')
                ->pause(1000)
                ->assertVisible('@register-button');
        });
    }

    /** @test */
    public function register_form_validation()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/register')
            ->pause(500)
            ->script("document.querySelectorAll('[required]').forEach(el => el.removeAttribute('required'));");

        $browser->press('@register-button')
            ->pause(1000)
            ->assertSee('The first name field is required');
    });
}


    /** @test */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->pause(1000)
                ->type('first_name', 'John')
                ->pause(500)
                ->type('last_name', 'Doe')
                ->pause(500)
                ->type('birthdate', '01-01-2001') 
                ->pause(500)
                ->type('email', 'john@example.com')
                ->pause(500)
                ->type('password', 'password')
                ->pause(500)
                ->type('password_confirmation', 'password')
                ->pause(500)
                ->press('@register-button')
                ->pause(1500)
                ->assertPathIs('/email/verify');
        });
    }
}
