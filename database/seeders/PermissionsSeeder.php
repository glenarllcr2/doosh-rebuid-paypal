<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // تعریف permission ها
        $permissions = [
            'send_message', // ارسال پیام
            'send_emoji', // ارسال ایموجی
            'view_message', // مشاهده پیام
            'message_length_limit_128', // محدودیت طول پیام به ۱۲۸ کاراکتر
            'message_length_limit_512', // محدودیت طول پیام به ۵۱۲ کاراکتر
        ];

        // ایجاد permission ها در جدول permissions
        foreach ($permissions as $permissionName) {
            Permission::create([
                'name' => $permissionName,
            ]);
        }

        // دریافت پلن ها
        $plans = Plan::all();

        // تعیین اینکه کدام پلن‌ها چه دسترسی‌هایی دارند
        foreach ($plans as $plan) {
            $permissions = [];
        
            if ($plan->name == 'C') {
                $permissions = ['send_emoji'];
            } elseif ($plan->name == 'B') {
                $permissions = ['send_emoji', 'send_message', 'view_message', 'message_length_limit_128'];
            } elseif ($plan->name == 'A') {
                $permissions = ['send_emoji', 'send_message', 'view_message', 'message_length_limit_512'];
            }
        
            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
        
                if ($permission) {
                    try {
                        $plan->permissions()->syncWithoutDetaching([$permission->id]);
                    } catch (\Exception $e) {
                        echo "Error attaching permission {$permissionName} to plan {$plan->name}: " . $e->getMessage();
                    }
                }
            }
        }
        
        $this->command->info('Permissions and plan_permission relationships have been seeded successfully!');
    }
}
