<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Spatie\Permission\Models\Permission;

class CertificateTemplateListTest extends DuskTestCase
{
    public function test_certificate_template_list_and_create_page_are_accessible()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'janleoegamen6@gmail.com')->firstOrFail();

            Permission::findOrCreate('view certificates');
            Permission::findOrCreate('create certificates');
            $user->syncPermissions(['view certificates', 'create certificates']);

            $browser->loginAs($user)

                ->visit('/certificates')
                ->pause(1000)
                ->assertSee('Certificate Templates')
                ->assertPathIs('/certificates')

                ->click('@certificates-create-button') 
                ->pause(1000)
                ->assertPathIs('/certificates/create')

                ->back()
                ->pause(500)
                ->assertPathIs('/certificates');
        });
    }
}
