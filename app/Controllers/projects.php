<?php
namespace App\Controllers;

class Projects extends BaseController
{
    public function show(string $slug)
    {
        // topics để hiển thị menu giống trang chủ (tạm hardcode)
        $topics = ['Concept', 'Portrait', 'Street', 'Event', 'Product', 'Fashion', 'Couple', 'Studio'];

        // Quét ảnh trong public/assets/images/projects/<slug>/*
        $diskDir = FCPATH . "assets/images/projects/{$slug}";
        $webDir  = base_url("assets/images/projects/{$slug}");

        $files = [];
        if (is_dir($diskDir)) {
            $files = glob($diskDir . '/*.{jpg,jpeg,png,webp,avif}', GLOB_BRACE);
        }
        $images = array_map(fn($p) => $webDir . '/' . basename($p), $files);

        // Nếu chưa có ảnh thì dùng ảnh demo
        if (empty($images)) {
            $images = [
                base_url('assets/images/mini1.jpg'),
                base_url('assets/images/mini2.jpg'),
                base_url('assets/images/mini3.jpg'),
                base_url('assets/images/mini3.jpg'),
                base_url('assets/images/mini3.jpg'),
                base_url('assets/images/mini3.jpg'),
            ];
        }

        // Thông tin project mẫu
        $project = [
            'name'  => ucwords(str_replace('-', ' ', $slug)),
            'slug'  => $slug,
            'cover' => $images[0] ?? '',
            'desc'  => 'Ghi chú nhanh về concept, ánh sáng, gear…',
            'meta'  => [
                'category' => 'Portrait',
                'gear'     => 'Sony A7C • 35mm f/1.8',
                'location' => 'HCM',
                'date'     => date('M j, Y'),
            ],
        ];

        return view('projects/show', [
            'topics'  => $topics,
            'project' => $project,
            'images'  => $images,
        ]);
    }
}
