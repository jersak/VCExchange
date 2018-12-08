<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Notification;
use App\Models\NotificationType;

class NotificationControllerTest extends TestCase
{
    public function testFunctionsExistence()
    {
        $this->assertTrue(method_exists(\App\Http\Controllers\NotificationController::class, 'createNotification'));
        $this->assertTrue(method_exists(\App\Http\Controllers\NotificationController::class, 'getNotifications'));
        $this->assertTrue(method_exists(\App\Http\Controllers\NotificationController::class, 'markUserNotificationsAsRead'));
        $this->assertFalse(method_exists(\App\Http\Controllers\HomeController::class, 'myFunction'));
    }

    public function testCreateNotification()
    {
        $user = User::inRandomOrder()->first();
        $notificationType = NotificationType::inRandomOrder()->first();

        $response = app('App\Http\Controllers\NotificationController')->createNotification($user->id, $notificationType->id);

        $data = $response->getData();

        $this->assertTrue($response->status() == 200);
        $this->assertEmpty(!($data));
    }

    public function testCreateNotificationInvalidUser()
    {
        $notificationType = NotificationType::inRandomOrder()->first();

        $response = app('App\Http\Controllers\NotificationController')->createNotification(99999999, $notificationType->id);

        $data = $response->getData();
        
        $this->assertTrue($response->status() == 404);
        $this->assertEquals($data, 'Destinatary not found.');
    }

    public function testCreateNotificationInvalidNotificationType()
    {
        $user = User::inRandomOrder()->first();

        $response = app('App\Http\Controllers\NotificationController')->createNotification($user->id, 99999);

        $data = $response->getData();
        
        $this->assertTrue($response->status() == 404);
        $this->assertEquals($data, 'Notification type not found.');
    }


    public function testGetNotificationsNotificationInvalidUser()
    {
        $response = app('App\Http\Controllers\NotificationController')->getNotifications(99999);

        $data = $response->getData();
        
        $this->assertTrue($response->status() == 404);
        $this->assertEquals($data, 'User not found.');
    }

    public function testMarkUserNotificationsAsRead()
    {
        $user = User::inRandomOrder()->first();

        $response = app('App\Http\Controllers\NotificationController')->markUserNotificationsAsRead($user->id);

        $data = $response->getData();
        
        $this->assertTrue($response->status() == 204);
        $this->assertEquals($data, '');
    }

    public function testMarkUserNotificationsAsReadInvalidUser()
    {
        $response = app('App\Http\Controllers\NotificationController')->markUserNotificationsAsRead(99999);

        $data = $response->getData();
        
        $this->assertTrue($response->status() == 404);
        $this->assertEquals($data, 'User not found.');
    }
}
