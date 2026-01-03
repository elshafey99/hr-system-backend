<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_name'       => [
                'en' => 'HR System',
                'ar' => 'نظام إدارة الموظفين',
            ],
            'site_desc'       => [
                'en' => "HR System is a comprehensive solution for managing employee data, attendance, and payroll. It provides a user-friendly interface for HR professionals to perform their tasks efficiently.",
                'ar' => 'نظام إدارة الموظفين هو حل شامل لإدارة بيانات الموظفين، الحضور والغمر، والرواتب. يوفر واجهة مستخدم سهلة الاستخدام لمحترفين إدارة الموظفين لتنفيذ مهامهم بكفاءة.',
            ],

            'site_phone'      => '+123456789',
            'site_address'    => [
                'en' => 'Address in English',
                'ar' => 'العنوان بالعربية',
            ],
            'about_us'    => [
                'en' => 'About in English',
                'ar' => 'من نحن بالعربية',
            ],
            'site_email'      => 'info@mywebsite.com',
            'email_support'   => 'support@mywebsite.com',
            'facebook'        => 'https://facebook.com/',
            'x_url'           => 'https://x.com',
            'youtube'         => 'https://youtube.com/',
            'meta_desc'       => [
                'en' => "HR System is a comprehensive solution for managing employee data, attendance, and payroll. It provides a user-friendly interface for HR professionals to perform their tasks efficiently.",
                'ar' => 'نظام إدارة الموظفين هو حل شامل لإدارة بيانات الموظفين، الحضور والغمر، والرواتب. يوفر واجهة مستخدم سهلة الاستخدام لمحترفين إدارة الموظفين لتنفيذ مهامهم بكفاءة.',
            ],
            'logo'            => 'uploads/images/logo.png',
            'favicon'         => 'uploads/images/logo.png',
            'site_copyright'  => '© 2025 My Website. All rights reserved.',
            'promotion_url'   => 'https://mywebsite.com/promotion',

        ]);
    }
}
