<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Demo catalogue used for the face-to-face demonstration.
     *
     * @var list<array{name: string, qty: int, price: float, description: string, image: string|null}>
     */
    private const PRODUCTS = [
        [
            'name' => 'Aurora Wireless Headphones',
            'qty' => 24,
            'price' => 5499.00,
            'description' => 'Over-ear Bluetooth headphones with active noise cancellation and 40-hour battery life.',
            'image' => 'headphones.png',
        ],
        [
            'name' => 'Nomad Mechanical Keyboard',
            'qty' => 18,
            'price' => 3299.00,
            'description' => 'Hot-swappable 75% mechanical keyboard with tactile switches and RGB backlighting.',
            'image' => 'keyboard.png',
        ],
        [
            'name' => 'Glide Ergonomic Mouse',
            'qty' => 42,
            'price' => 1299.00,
            'description' => 'Vertical wireless mouse designed to reduce wrist strain during long work sessions.',
            'image' => 'mouse.png',
        ],
        [
            'name' => 'Vista 27" QHD Monitor',
            'qty' => 9,
            'price' => 15499.00,
            'description' => '27-inch 165 Hz QHD display with HDR support and a height-adjustable stand.',
            'image' => 'monitor.png',
        ],
        [
            'name' => 'Pulse Bluetooth Speaker',
            'qty' => 31,
            'price' => 2499.00,
            'description' => 'Portable IPX7 waterproof speaker with deep bass and 20-hour playback.',
            'image' => 'speaker.png',
        ],
        [
            'name' => 'Focus 4K Webcam',
            'qty' => 15,
            'price' => 3899.00,
            'description' => '4K webcam with autofocus, dual microphones, and a privacy shutter.',
            'image' => 'webcam.png',
        ],
        [
            'name' => 'Link 8-in-1 USB-C Hub',
            'qty' => 57,
            'price' => 1899.00,
            'description' => 'Aluminium hub with HDMI, Gigabit Ethernet, SD reader, and 100 W pass-through charging.',
            'image' => 'hub.png',
        ],
        [
            'name' => 'Rise Aluminium Laptop Stand',
            'qty' => 63,
            'price' => 999.00,
            'description' => 'Adjustable stand that raises a laptop to eye level for better posture.',
            'image' => 'stand.png',
        ],
        [
            'name' => 'Echo Noise-Cancelling Earbuds',
            'qty' => 27,
            'price' => 4299.00,
            'description' => 'Compact true-wireless earbuds with transparency mode and a wireless charging case.',
            'image' => 'earbuds.png',
        ],
        [
            'name' => 'Vault Portable SSD 1 TB',
            'qty' => 12,
            'price' => 5199.00,
            'description' => 'Pocket-sized USB 3.2 solid-state drive with hardware encryption.',
            'image' => 'ssd.png',
        ],
        [
            'name' => 'Orbit Smart Watch',
            'qty' => 6,
            'price' => 6999.00,
            'description' => 'Fitness smart watch with heart-rate tracking, GPS, and a seven-day battery.',
            'image' => null,
        ],
        [
            'name' => 'Atlas Cable Organiser',
            'qty' => 88,
            'price' => 449.00,
            'description' => 'Desk-mounted cable management tray with six reusable magnetic ties.',
            'image' => null,
        ],
    ];

    public function run(): void
    {
        foreach (self::PRODUCTS as $product) {
            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                [
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'description' => $product['description'],
                    'image_path' => $this->storeImage($product['image']),
                ],
            );
        }
    }

    /**
     * Copy a bundled sample image onto the public disk.
     */
    private function storeImage(?string $file): ?string
    {
        if ($file === null) {
            return null;
        }

        $path = ProductImageService::DIRECTORY.'/'.$file;
        $source = database_path('seeders/images/'.$file);

        if (! is_file($source)) {
            return null;
        }

        Storage::disk(ProductImageService::DISK)->put($path, file_get_contents($source));

        return $path;
    }
}
