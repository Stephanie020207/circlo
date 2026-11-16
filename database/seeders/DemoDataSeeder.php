<?php

namespace Database\Seeders;

use App\Models\ItemListing;
use App\Models\ListingType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Mock data for Circlo. Safe to run more than once (it skips rows that already exist).
 *
 *   php artisan db:seed --class=DemoDataSeeder
 *
 * Every demo account uses the password: password123
 */
class DemoDataSeeder extends Seeder
{
    // Set to false if saving the bytea photos gives an error; listings are then created without photos.
    private bool $withPhotos = true;

    // Tiny solid-colour PNGs used as placeholder photos (the UI stretches them to fill the card).
    private array $photoColors = [
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGNIbjkCAAL5AayHWMGvAAAAAElFTkSuQmCC',
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGOIW7UAAAMSAamdrRLYAAAAAElFTkSuQmCC',
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGN4sCoAAARIAduOlm1vAAAAAElFTkSuQmCC',
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGM4l9cEAAPMAb8MuzKMAAAAAElFTkSuQmCC',
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGOYVnECAAN+AdcpgjGUAAAAAElFTkSuQmCC',
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADElEQVR4nGPI21IBAAMuAZv4+ZJNAAAAAElFTkSuQmCC',
    ];

    public function run(): void
    {
        $this->seedLookups();

        $password = Hash::make('password123');

        $users = [
            // email => [name, student_id, role]
            'admin@circlo.test'  => ['Rina Admin', null, 'admin'],
            'alya@student.test'  => ['Alya Putri', '5026240001', 'student'],
            'budi@student.test'  => ['Budi Santoso', '5026240002', 'student'],
            'dewi@student.test'  => ['Dewi Lestari', '5026240003', 'student'],
            'rizky@student.test' => ['Rizky Aditya', '5026240004', 'student'],
            'sari@student.test'  => ['Sari Maharani', '5026240005', 'student'],
            'andi@student.test'  => ['Andi Pratama', '5026240006', 'student'],
            'tono@student.test'  => ['Tono Wijaya', '5026240007', 'student'],
        ];

        $ids = [];
        foreach ($users as $email => [$name, $studentId, $role]) {
            $user = User::where('email', $email)->first() ?? User::forceCreate([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'student_id' => $studentId,
                'role' => $role,
                'campus_pickup_point' => 'Campus Library',
                'about' => $role === 'student' ? 'Happy to lend things out to fellow students.' : null,
            ]);
            $ids[$email] = $user->id;
        }

        // owner email, item name, category, type, condition, price per day, pickup, availability, description
        $items = [
            ['budi@student.test',  'Macbook Air M1', 'Electronics', 'Renting', 'Like new', 50000, 'Campus Library', 'Available', '8GB RAM, 256GB SSD. Comes with charger and sleeve. Great for design and coding classes.'],
            ['dewi@student.test',  'Textbook Calculus', 'Books', 'Lending', 'Good', 0, 'Faculty of Mathematics lobby', 'Available', 'Calculus textbook, 8th edition. A few pencil notes inside, nothing that gets in the way.'],
            ['rizky@student.test', 'Canon EOS Camera', 'Electronics', 'Renting', 'Good', 75000, 'Department building lobby', 'Booked', 'DSLR with 18-55mm lens, battery, and a camera bag. Please handle with care.'],
            ['sari@student.test',  'Camping Tent (4 persons)', 'Equipment', 'Renting', 'Good', 40000, 'Dormitory gate', 'Available', 'Waterproof dome tent, easy to set up. Poles and pegs included.'],
            ['andi@student.test',  'Jacket Hoodie', 'Fashion', 'Sharing', 'Like new', 0, 'Student center', 'Available', 'Size L hoodie, warm and clean. Free to borrow for events or cold lab days.'],
            ['tono@student.test',  'Road Bike', 'Sports', 'Renting', 'Fair', 60000, 'Sports hall parking', 'Booked', '21-speed road bike. Brakes recently serviced. Helmet not included.'],
            ['dewi@student.test',  'Scientific Calculator Casio fx-991', 'Electronics', 'Lending', 'Good', 0, 'Campus Library', 'Available', 'Allowed in most exams. Batteries are fresh.'],
            ['sari@student.test',  'Formal Blazer (size M)', 'Fashion', 'Renting', 'Like new', 25000, 'Student center', 'Available', 'Black blazer, perfect for presentations, interviews, and formal events.'],
            ['andi@student.test',  'Badminton Racket Set', 'Sports', 'Lending', 'Good', 0, 'Sports hall', 'Available', 'Two rackets and three shuttlecocks.'],
            ['budi@student.test',  'Data Structures Textbook', 'Books', 'Sharing', 'Good', 0, 'Faculty lobby', 'Available', 'Free to borrow. Please return it before the semester ends.'],
            ['rizky@student.test', 'Portable Projector', 'Electronics', 'Renting', 'Like new', 80000, 'Department office', 'Available', 'Mini HDMI projector with a small tripod. Handy for group presentations.'],
            ['alya@student.test',  'Phone Tripod', 'Equipment', 'Lending', 'Like new', 0, 'Campus Library', 'Available', 'Adjustable tripod with a Bluetooth shutter remote.'],
            ['alya@student.test',  'Yoga Mat', 'Sports', 'Sharing', 'New', 0, 'Campus Library', 'Available', 'Never used. Free to borrow.'],
        ];

        foreach ($items as $i => [$email, $name, $category, $type, $condition, $price, $pickup, $availability, $description]) {
            $listing = ItemListing::where('owner_id', $ids[$email])->where('item_name', $name)->first()
                ?? ItemListing::forceCreate([
                    'owner_id' => $ids[$email],
                    'category_id' => Category::where('category_name', $category)->value('id'),
                    'listing_type_id' => ListingType::where('type_name', $type)->value('id'),
                    'item_name' => $name,
                    'description' => $description,
                    'condition' => $condition,
                    'price_per_day' => $price,
                    'pickup_location' => $pickup,
                    'availability' => $availability,
                    'listing_status' => 'Published',
                ]);

            if ($this->withPhotos && ! $listing->photos()->exists()) {
                $this->addPhoto($listing, $this->photoColors[$i % count($this->photoColors)]);
            }
        }
    }

    private function seedLookups(): void
    {
        DB::table('listing_types')->updateOrInsert(['type_name' => 'Sharing'], ['is_free' => true]);
        DB::table('listing_types')->updateOrInsert(['type_name' => 'Lending'], ['max_loan_days' => 14]);
        DB::table('listing_types')->updateOrInsert(['type_name' => 'Renting'], ['min_rental_days' => 1]);

        foreach (['Books', 'Electronics', 'Fashion', 'Sports', 'Equipment'] as $category) {
            DB::table('categories')->updateOrInsert(['category_name' => $category], ['description' => null]);
        }
    }

    // photo is a bytea column, so the image is passed as a stream
    private function addPhoto(ItemListing $listing, string $base64): void
    {
        $stream = fopen('php://memory', 'r+b');
        fwrite($stream, base64_decode($base64));
        rewind($stream);

        $listing->photos()->create(['photo' => $stream]);

        fclose($stream);
    }
}