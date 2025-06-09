<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Data options
        $statuses = ['Pending', 'Approved', 'Rejected'];
        $sexes = ['Male', 'Female'];
        $civilStatuses = ['Single', 'Married', 'Widowed', 'Separated'];
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $licenseClasses = ['A', 'B', 'C', 'D', 'E'];
        $relationships = ['Father', 'Mother', 'Spouse', 'Sibling', 'Friend'];

        // Create a user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            // Fetch random address from PSGC reference tables
            $region = DB::table('ref_psgc_region')->inRandomOrder()->first();

            $province = DB::table('ref_psgc_province')
                ->where('PSGC_REG_CODE', $region->PSGC_REG_CODE)
                ->inRandomOrder()
                ->first();

            $municipality = DB::table('ref_psgc_municipality')
                ->where('PSGC_PROV_CODE', $province->PSGC_PROV_CODE)
                ->inRandomOrder()
                ->first();

            $barangay = DB::table('ref_psgc_barangay')
                ->where('PSGC_MUNC_CODE', $municipality->PSGC_MUNC_CODE)
                ->inRandomOrder()
                ->first();

            $birthdate = $faker->dateTimeBetween('-60 years', '-18 years');
            $hasLicense = $faker->boolean(70); // 70% chance

            Applicant::create([
                'status' => $faker->randomElement($statuses),
                'last_name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'middle_name' => $faker->firstName,
                'suffix' => $faker->randomElement(['', 'Jr.', 'Sr.', 'II', 'III', 'IV']),
                'sex' => $faker->randomElement($sexes),
                'birthdate' => $birthdate,
                'civil_status' => $faker->randomElement($civilStatuses),
                'citizenship' => 'Filipino',
                'blood_type' => $faker->randomElement($bloodTypes),
                'cellphone_no' => '09' . $faker->numerify('#########'),
                'telephone_no' => $faker->numerify('########'),
                'email_address' => $faker->unique()->safeEmail,
                'emergency_contact' => $faker->name,
                'emergency_contact_number' => '09' . $faker->numerify('#########'),
                'relationship' => $faker->randomElement($relationships),
                'license_class' => $hasLicense ? $faker->randomElement($licenseClasses) : 'N/A',
                'license_number' => $hasLicense ? $faker->bothify('??#########') : 'N/A',
                'license_expiration_date' => $hasLicense ? $faker->dateTimeBetween('now', '+5 years') : now()->addYear(),
                'user_id' => $user->id,
                // Use PSGC codes and descriptions from DB
                'region' => $region->PSGC_REG_CODE,        // or $region->PSGC_REG_CODE if you want codes
                'province' => $province->PSGC_PROV_CODE,   // or $province->PSGC_PROV_CODE
                'municipality' => $municipality->PSGC_MUNC_CODE, // or code
                'barangay' => $barangay->PSGC_BRGY_CODE,  // or code
                'house_building_number_name' => $faker->buildingNumber,
                'street_address' => $faker->streetAddress,
                'zip_code' => $barangay->ZIP_CODE ?? null, // Use zip code if available
                'is_student' => $faker->boolean(30),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
