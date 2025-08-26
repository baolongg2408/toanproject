<?php
namespace App\Controllers;

class Profile extends BaseController
{
    public function index()
    {
        helper('url');

        // Mock data (sau này nối DB)
        $topics = ['Concept', 'Portrait', 'Street', 'Event', 'Product', 'Fashion', 'Couple', 'Studio'];
        $heroPoster = base_url('assets/images/hero.jpg'); // đặt file ảnh vào public/assets/images/hero.jpg

        // Poster nhỏ (slider “quảng cáo”)
        $miniPosters = [
            ['src' => base_url('assets/images/mini1.jpg'), 'title' => 'Night Street'],
            ['src' => base_url('assets/images/mini2.jpg'), 'title' => 'Live Show'],
            ['src' => base_url('assets/images/mini3.jpg'), 'title' => 'Product Shot'],
            ['src' => base_url('assets/images/mini4.jpg'), 'title' => 'Concept Noir'],
            ['src' => base_url('assets/images/mini5.jpg'), 'title' => 'Portrait Linh'],
            ['src' => base_url('assets/images/mini6.jpg'), 'title' => 'Travel Mood'],
        ];

        // Dự án nổi bật (grid)
        $featured = [
            [
                'cover' => base_url('assets/images/feat1.jpg'),
                'name'  => 'Urban Rain',
                'desc'  => 'Street • ƒ1.8 • ISO3200'
            ],
            [
                'cover' => base_url('assets/images/feat2.jpg'),
                'name'  => 'Minimal Product',
                'desc'  => 'Product • Softbox top'
            ],
            [
                'cover' => base_url('assets/images/feat3.jpg'),
                'name'  => 'Concept Blue',
                'desc'  => 'Concept • HCM'
            ],
            [
                'cover' => base_url('assets/images/feat4.jpg'),
                'name'  => 'Portrait Series',
                'desc'  => 'Portrait • Natural light'
            ],
        ];

        return view('profile', [
            'topics'      => $topics,
            'heroPoster'  => $heroPoster,
            'miniPosters' => $miniPosters,
            'featured'    => $featured,
        ]);
    }
}
