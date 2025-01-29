<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInUsersTable extends Migration
{
    public function up()
    {
        // مرحله ۱: اضافه کردن مقدار جدید 'suspended' به ENUM
        DB::statement("ALTER TABLE `users` CHANGE `status` `status` ENUM('active', 'pending', 'rejected', 'blocked', 'suspended') NOT NULL DEFAULT 'pending'");

        // مرحله ۲: تغییر مقادیر 'rejected' به 'suspended'
        DB::table('users')
            ->where('status', 'rejected')
            ->update(['status' => 'suspended']);

        // مرحله ۳: حذف مقدار 'rejected' از ENUM
        DB::statement("ALTER TABLE `users` CHANGE `status` `status` ENUM('active', 'pending', 'suspended', 'blocked') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        // بازگرداندن مقدار 'rejected' به ENUM
        DB::statement("ALTER TABLE `users` CHANGE `status` `status` ENUM('active', 'pending', 'rejected', 'suspended', 'blocked') NOT NULL DEFAULT 'pending'");

        // بازگرداندن مقادیر 'suspended' به 'rejected'
        DB::table('users')
            ->where('status', 'suspended')
            ->update(['status' => 'rejected']);

        // حذف مقدار 'suspended' از ENUM
        DB::statement("ALTER TABLE `users` CHANGE `status` `status` ENUM('active', 'pending', 'rejected', 'blocked') NOT NULL DEFAULT 'pending'");
    }
}
