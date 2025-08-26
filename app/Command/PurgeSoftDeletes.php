<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class PurgeSoftDeletes extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'purge:soft';
    protected $description = 'Xóa vĩnh viễn các bản ghi đã soft delete quá số ngày chỉ định';

    public function run(array $params)
    {
        $days   = (int) (CLI::getOption('days') ?? 180);
        $tables = CLI::getOption('tables');
        $tables = $tables ? array_map('trim', explode(',', $tables)) : ['photos']; // mặc định xử lý bảng photos

        $db    = Database::connect();
        $limit = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        foreach ($tables as $table) {
            // Bỏ qua bảng không có cột deleted_at
            $fields = $db->getFieldNames($table);
            if (!in_array('deleted_at', $fields, true)) {
                CLI::write("- Bỏ qua {$table}: không có cột deleted_at", 'yellow');
                continue;
            }

            // Xóa vĩnh viễn các dòng đã soft-delete trước mốc $limit
            $builder = $db->table($table);
            $builder->where('deleted_at IS NOT NULL', null, false)
                    ->where('deleted_at <', $limit)
                    ->delete();

            $aff = $db->affectedRows();
            CLI::write("✓ {$table}: đã xóa {$aff} dòng (trước {$limit})", 'green');
        }
    }
}
// Lệnh chạy xóa các bản ghi database đã xóa quá 180 day php spark purge:soft
