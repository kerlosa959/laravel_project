<?php

namespace Database\Seeders;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermissions = [
            [
                'name' => 'manage labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'view labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'accept labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'reject labour request',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        Permission::insert($arrPermissions);

        // Super admin

        $superAdminRole        = Role::create(
            [
                'name' => 'super admin',
                'created_by' => 0,
            ]
        );
        $superAdminPermissions = [
            ['name' => 'manage super admin dashboard'],
            ['name' => 'manage user'],
            ['name' => 'create user'],
            ['name' => 'edit user'],
            ['name' => 'delete user'],
            ['name' => 'create language'],
            ['name' => 'manage system settings'],
            ['name' => 'manage stripe settings'],
            ['name' => 'manage role'],
            ['name' => 'create role'],
            ['name' => 'edit role'],
            ['name' => 'delete role'],
            ['name' => 'manage permission'],
            ['name' => 'create permission'],
            ['name' => 'edit permission'],
            ['name' => 'delete permission'],
            ['name' => 'manage plan'],
            ['name' => 'create plan'],
            ['name' => 'edit plan'],
            ['name' => 'manage order'],
            ['name' => 'manage coupon'],
            ['name' => 'create coupon'],
            ['name' => 'edit coupon'],
            ['name' => 'delete coupon'],
        ];

        $superAdminRole->givePermissionTo($superAdminPermissions);

        $superAdmin = User::create(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('1234'),
                'type' => 'super admin',
                'lang' => 'en',
                'avatar' => '',
                'created_by' => 0,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // customer
        $customerRole       = Role::create(
            [
                'name' => 'customer',
                'created_by' => 0,
            ]
        );
        $customerPermission = [
            ['name' => 'manage customer payment'],
            ['name' => 'manage customer transaction'],
            ['name' => 'manage customer invoice'],
            ['name' => 'show invoice'],
            ['name' => 'show proposal'],
            ['name' => 'manage customer proposal'],
            ['name' => 'show customer'],
        ];
        $customerRole->givePermissionTo($customerPermission);

        // vender
        $venderRole       = Role::create(
            [
                'name' => 'vender',
                'created_by' => 0,
            ]
        );
        $venderPermission = [
            ['name' => 'vender manage bill'],
            ['name' => 'manage vender bill'],
            ['name' => 'manage vender payment'],
            ['name' => 'manage vender transaction'],
            ['name' => 'show vender'],
            ['name' => 'show bill'],
        ];

        $venderRole->givePermissionTo($venderPermission);

        // company

        $companyRole = Role::create(
            [
                'name' => 'company',
                'created_by' => 0,
            ]
        );

        $companyPermissions = [

            ['name' => 'manage labour request'],
            ['name' => 'create labour request'],
            ['name' => 'view labour request'],
            ['name' => 'edit labour request'],
            ['name' => 'delete labour request'],
            ['name' => 'accept labour request'],
            ['name' => 'reject labour request'],

        ];

        $companyRole->givePermissionTo($companyPermissions);

        $company = User::create(
            [
                'name' => 'company',
                'email' => 'company@example.com',
                'password' => Hash::make('1234'),
                'type' => 'company',
                'default_pipeline' => 1,
                'plan' => 1,
                'lang' => 'en',
                'avatar' => '',
                'created_by' => 1,
                'email_verified_at' => now(),
            ]
        );
        $company->assignRole($companyRole);

        // accountant
        $accountantRole       = Role::create(
            [
                'name' => 'accountant',
                'created_by' => $company->id,
            ]
        );
        $accountantPermission = [

            ['name' => 'manage labour request'],
            ['name' => 'create labour request'],
            ['name' => 'view labour request'],
            ['name' => 'edit labour request'],
            ['name' => 'delete labour request'],
            ['name' => 'accept labour request'],
            ['name' => 'reject labour request'],
        ];


        $accountantRole->givePermissionTo($accountantPermission);

        $accountant = User::create(
            [
                'name' => 'accountant',
                'email' => 'accountant@example.com',
                'password' => Hash::make('1234'),
                'type' => 'accountant',
                'default_pipeline' => 1,
                'lang' => 'en',
                'avatar' => '',
                'created_by' => $company->id,
                'email_verified_at' => now(),
            ]
        );
        $accountant->assignRole($accountantRole);

        \App\Models\BankAccount::create(
            [
                'holder_name' => 'cash',
                'bank_name' => '',
                'account_number' => '-',
                'opening_balance' => '0.00',
                'contact_number' => '-',
                'bank_address' => '-',
                'created_by' => $company->id,
            ]
        );

        // accountant
        $clientRole       = Role::create(
            [
                'name' => 'client',
                'created_by' => $company->id,
            ]
        );
        $clientPermission = [
            ['name' => 'manage client dashboard'],
            ['name' => 'manage bug report'],
            ['name' => 'create bug report'],
            ['name' => 'edit bug report'],
            ['name' => 'delete bug report'],
            ['name' => 'move bug report'],
            ['name' => 'view deal'],
            ['name' => 'manage deal'],
            ['name' => 'manage project'],
            ['name' => 'view project'],
            ['name' => 'view grant chart'],
            ['name' => 'view timesheet'],
            ['name' => 'manage timesheet'],
            ['name' => 'manage project task'],
            ['name' => 'create project task'],
            ['name' => 'edit project task'],
            ['name' => 'view project task'],
            ['name' => 'delete project task'],
            ['name' => 'view activity'],
            ['name' => 'view task'],
            ['name' => 'manage pipeline'],
            ['name' => 'manage lead stage'],
            ['name' => 'manage label'],
            ['name' => 'manage source'],
            ['name' => 'move deal'],
            ['name' => 'manage stage'],
            ['name' => 'manage contract'],
            ['name' => 'show contract'],
        ];

        $clientRole->givePermissionTo($clientPermission);

        $client = User::create(
            [
                'name' => 'client',
                'email' => 'client@example.com',
                'password' => Hash::make('1234'),
                'type' => 'client',
                'default_pipeline' => 1,
                'lang' => 'en',
                'avatar' => '',
                'created_by' => $company->id,
                'email_verified_at' => now(),
            ]
        );
        $client->assignRole($clientRole);

        Utility::employeeDetails($accountant->id, $company->id);
        // Utility::employeeDetails($client->id,$company->id);
        Utility::chartOfAccountTypeData($company->id);
        Utility::chartOfAccountData($company);
        Utility::pipeline_lead_deal_Stage($company->id);
        Utility::project_task_stages($company->id);
        Utility::labels($company->id);
        Utility::sources($company->id);
        Utility::jobStage($company->id);
        $company->defaultEmail();
        $company::userDefaultData();
        $company::userDefaultWarehouse();
        GenerateOfferLetter::defaultOfferLetter();
        ExperienceCertificate::defaultExpCertificat();
        JoiningLetter::defaultJoiningLetter();
        NOC::defaultNocCertificate();
        Utility::languagecreate();

        $data = [
            ['name'=>'local_storage_validation', 'value'=> 'jpg,jpeg,png,xlsx,xls,csv,pdf', 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'wasabi_storage_validation', 'value'=> 'jpg,jpeg,png,xlsx,xls,csv,pdf', 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'s3_storage_validation', 'value'=> 'jpg,jpeg,png,xlsx,xls,csv,pdf', 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'local_storage_max_upload_size', 'value'=> 2048000, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'wasabi_max_upload_size', 'value'=> 2048000, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'s3_max_upload_size', 'value'=> 2048000, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()]
        ];
        DB::table('settings')->insert($data);

    }
}
