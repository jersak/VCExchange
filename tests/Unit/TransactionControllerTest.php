<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\User;

class TransactionControllerTest extends TestCase
{
    public function testFunctionsExistence()
    {
        $this->assertTrue(method_exists(\App\Http\Controllers\TransactionController::class, 'createTransaction'));
        $this->assertTrue(method_exists(\App\Http\Controllers\TransactionController::class, 'createBulkTransactions'));
        $this->assertTrue(method_exists(\App\Http\Controllers\TransactionController::class, 'getUserTransactions'));
        $this->assertFalse(method_exists(\App\Http\Controllers\TransactionController::class, 'myFunction'));
    }

    public function testCreateTransaction()
    {
        $request = new Request;

        $query = [
            'from' => User::inRandomOrder()->first()->email,
            'to' => User::inRandomOrder()->first()->email,
            'amount' => rand(1, 2),
        ];

        $request->replace($query);

        $response = app('App\Http\Controllers\TransactionController')->createTransaction($request);

        $data = $response->getData();
        $this->assertTrue($response->status() == 200);
        $this->assertEmpty(!($data));
    }

    public function testCreateTransactionInvalidEmail()
    {
        $request = new Request;

        $query = [
            'from' => 'asdfg',
            'to' => 'qwert',
            'amount' => rand(1, 2),
        ];

        $request->replace($query);

        $response = app('App\Http\Controllers\TransactionController')->createTransaction($request);

        $data = $response->getData();
        $this->assertTrue($response->status() == 422);
        $this->assertEmpty(!($data));
    }

    public function testCreateTransactionInexistentUser()
    {
        $request = new Request;

        $query = [
            'from' => 'thisemail@doesntexist.com',
            'to' => 'thisalso@doesntexist.com',
            'amount' => rand(1, 2),
        ];

        $request->replace($query);

        $response = app('App\Http\Controllers\TransactionController')->createTransaction($request);

        $data = $response->getData();
        $this->assertTrue($response->status() == 422);
        $this->assertEmpty(!($data));
    }

    public function testCreateTransactionNotEnoughFunds()
    {
        $request = new Request;

        $query = [
            'from' => User::inRandomOrder()->first()->email,
            'to' => User::inRandomOrder()->first()->email,
            'amount' => rand(999000, 999999),
        ];

        $request->replace($query);

        $response = app('App\Http\Controllers\TransactionController')->createTransaction($request);

        $data = $response->getData();
        $this->assertTrue($response->status() == 422);
        $this->assertEmpty(!($data));
    }
}
