<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PostCategory;
use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $permissions = collect([
            ['Dashboard', 'dashboard.view', 'dashboard'],
            ['Quản lý xe', 'vehicles.manage', 'vehicles'],
            ['Quản lý bài viết', 'posts.manage', 'content'],
            ['Quản lý banner', 'banners.manage', 'content'],
            ['Quản lý lead', 'leads.manage', 'customers'],
            ['Quản lý cấu hình', 'settings.manage', 'settings'],
            ['Quản lý phân quyền', 'roles.manage', 'system'],
        ])->mapWithKeys(function (array $permission) {
            return [
                $permission[1] => Permission::updateOrCreate(
                    ['slug' => $permission[1]],
                    ['name' => $permission[0], 'group' => $permission[2]]
                ),
            ];
        });

        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );
        $adminRole->permissions()->sync($permissions->pluck('id'));

        $writerRole = Role::updateOrCreate(
            ['slug' => 'writer'],
            ['name' => 'Writer']
        );
        $writerRole->permissions()->sync(
            $permissions->only(['dashboard.view', 'posts.manage', 'banners.manage'])->pluck('id')
        );

        $admin = User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        );
        $admin->roles()->syncWithoutDetaching($adminRole);

        $family = VehicleCategory::updateOrCreate(
            ['slug' => 'dong-xe-du-lich-gia-dinh'],
            ['name' => 'Dòng xe du lịch - gia đình', 'sort_order' => 10, 'is_active' => true]
        );

        $green = VehicleCategory::updateOrCreate(
            ['slug' => 'dong-xe-green'],
            ['name' => 'Dòng xe Green', 'sort_order' => 20, 'is_active' => true]
        );

        foreach ([
            ['VINFAST VF3', 'vinfast-vf3', $family->id, 5, 275000000],
            ['VINFAST VF5 PLUS', 'vinfast-vf5-plus', $family->id, 5, 458000000],
            ['VINFAST VF6', 'vinfast-vf6', $family->id, 5, 634000000],
            ['VINFAST VF7', 'vinfast-vf7', $family->id, 5, null],
            ['VINFAST VF8', 'vinfast-vf8', $family->id, 5, 1057100000],
            ['VINFAST VF9', 'vinfast-vf9', $family->id, 7, 1443200000],
            ['HERIO GREEN', 'herio-green', $green->id, null, null],
            ['NERIO GREEN', 'nerio-green', $green->id, null, null],
            ['VINFAST MINIO GREEN', 'vinfast-minio-green', $green->id, null, null],
            ['VINFAST LIMO GREEN', 'vinfast-limo-green', $green->id, null, null],
        ] as [$name, $slug, $categoryId, $seatCount, $price]) {
            Vehicle::updateOrCreate(
                ['slug' => $slug],
                [
                    'vehicle_category_id' => $categoryId,
                    'name' => $name,
                    'seat_count' => $seatCount,
                    'price' => $price,
                    'price_text' => $price ? null : 'Liên hệ để có giá tốt',
                    'is_active' => true,
                ]
            );
        }

        foreach ([
            ['Tin tức & Sự kiện', 'tin-tuc-su-kien', 'news'],
            ['Khuyến mãi', 'khuyen-mai', 'promotion'],
            ['Bảng giá xe', 'bang-gia-xe', 'price'],
            ['Bảo hiểm - Phụ kiện', 'bao-hiem-phu-kien', 'service'],
        ] as [$name, $slug, $type]) {
            PostCategory::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'type' => $type, 'is_active' => true]
            );
        }

        foreach ([
            ['general', 'site_name', 'VinFast Hải Phòng', 'text', 'Tên website'],
            ['contact', 'sales_hotline', '0763386669', 'phone', 'Hotline tư vấn'],
            ['contact', 'test_drive_hotline', '0901336355', 'phone', 'Hotline lái thử'],
            ['contact', 'address', 'Hải Phòng', 'textarea', 'Địa chỉ showroom'],
            ['seo', 'home_meta_title', 'VinFast Hải Phòng - Showroom VinFast chính hãng', 'text', 'Meta title trang chủ'],
        ] as [$group, $key, $value, $type, $label]) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                compact('group', 'value', 'type', 'label')
            );
        }
    }
}
