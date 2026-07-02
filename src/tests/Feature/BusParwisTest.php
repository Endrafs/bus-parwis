<?php

use App\Models\Bus;
use App\Models\Booking;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Seed roles before each test
beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

// ============================================================
// PUBLIC PAGES
// ============================================================

test('landing page loads successfully', function () {
    Bus::factory(3)->create(['status' => true]);
    
    $response = $this->get('/');
    
    $response->assertStatus(200);
    $response->assertSee('Armada Bus');
});

test('bus detail page loads successfully', function () {
    $bus = Bus::factory()->create(['status' => true]);
    
    $response = $this->get(route('bus.show', $bus));
    
    $response->assertStatus(200);
    $response->assertSee($bus->nama_bus);
});

test('bus detail page returns 404 for non-existent bus', function () {
    $response = $this->get('/bus/99999');
    $response->assertStatus(404);
});

// ============================================================
// AUTHENTICATION
// ============================================================

test('register page loads', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

test('login page loads', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'nomor_whatsapp' => '62812345678',
        'email' => 'testuser@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', ['email' => 'testuser@test.com']);
    $this->assertAuthenticated();
});

// ============================================================
// BOOKING FLOW
// ============================================================

test('authenticated user can access booking form', function () {
    $user = User::factory()->create();
    $bus = Bus::factory()->create(['status' => true]);

    $response = $this->actingAs($user)
        ->get(route('booking.create', ['bus_id' => $bus->id]));

    $response->assertStatus(200);
    $response->assertSee($bus->nama_bus);
});

test('unauthenticated user cannot access booking form', function () {
    $bus = Bus::factory()->create();

    $response = $this->get(route('booking.create', ['bus_id' => $bus->id]));

    $response->assertRedirect('/login');
});

test('user can create booking', function () {
    $user = User::factory()->create();
    $bus = Bus::factory()->create(['status' => true, 'harga_sewa' => 4000000]);

    $response = $this->actingAs($user)->post('/booking', [
        'bus_id' => $bus->id,
        'tanggal_berangkat' => now()->addDays(5)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(7)->format('Y-m-d'),
        'tujuan' => 'Bandung',
        'catatan' => 'Test booking',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('bookings', [
        'user_id' => $user->id,
        'bus_id' => $bus->id,
        'tujuan' => 'Bandung',
        'status' => 'Pending',
        'jumlah_hari' => 2,
        'total_harga' => 8000000,
    ]);
});

test('double booking is prevented', function () {
    $user = User::factory()->create();
    $bus = Bus::factory()->create(['status' => true]);

    // Create first booking
    Booking::create([
        'user_id' => $user->id,
        'bus_id' => $bus->id,
        'kode_booking' => 'BUS-TEST-001',
        'tanggal_berangkat' => now()->addDays(10)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(12)->format('Y-m-d'),
        'tujuan' => 'Yogyakarta',
        'jumlah_hari' => 3,
        'total_harga' => 12000000,
        'status' => 'Dikonfirmasi',
    ]);

    // Try overlapping booking
    $response = $this->actingAs($user)->post('/booking', [
        'bus_id' => $bus->id,
        'tanggal_berangkat' => now()->addDays(11)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(14)->format('Y-m-d'),
        'tujuan' => 'Jakarta',
    ]);

    $response->assertSessionHasErrors('tanggal_berangkat');
});

test('user can view their bookings', function () {
    $user = User::factory()->create();
    $bus = Bus::factory()->create();

    Booking::create([
        'user_id' => $user->id,
        'bus_id' => $bus->id,
        'kode_booking' => 'BUS-TEST-002',
        'tanggal_berangkat' => now()->addDays(5)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(7)->format('Y-m-d'),
        'tujuan' => 'Surabaya',
        'jumlah_hari' => 3,
        'total_harga' => 12000000,
        'status' => 'Pending',
    ]);

    $response = $this->actingAs($user)->get('/my-bookings');

    $response->assertStatus(200);
    $response->assertSee('BUS-TEST-002');
    $response->assertSee('Surabaya');
});

test('user cannot view other users booking', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $bus = Bus::factory()->create();

    $booking = Booking::create([
        'user_id' => $user1->id,
        'bus_id' => $bus->id,
        'kode_booking' => 'BUS-OTHER-001',
        'tanggal_berangkat' => now()->addDays(5)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(7)->format('Y-m-d'),
        'tujuan' => 'Bali',
        'jumlah_hari' => 3,
        'total_harga' => 15000000,
        'status' => 'Pending',
    ]);

    $response = $this->actingAs($user2)
        ->get('/booking/' . $booking->kode_booking);

    $response->assertStatus(404);
});

test('booking auto-generates kode_booking', function () {
    $user = User::factory()->create();
    $bus = Bus::factory()->create();

    $booking = Booking::create([
        'user_id' => $user->id,
        'bus_id' => $bus->id,
        'tanggal_berangkat' => now()->addDays(5)->format('Y-m-d'),
        'tanggal_kembali' => now()->addDays(7)->format('Y-m-d'),
        'tujuan' => 'Bandung',
        'jumlah_hari' => 2,
        'total_harga' => 8000000,
        'status' => 'Pending',
    ]);

    expect($booking->kode_booking)->toMatch('/^BUS-\d{8}-\d{4}$/');
});

// ============================================================
// ADMIN PROTECTION
// ============================================================

test('non-admin user cannot access admin panel', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin');

    // Should get 403 since user doesn't have super_admin role
    $response->assertStatus(403);
});
