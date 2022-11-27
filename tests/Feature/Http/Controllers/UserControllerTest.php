<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {

        $users = User::factory()->count(10)->create();

        $this->get(route('users.index'))
            ->assertOk()
            ->assertSee($users->pluck('name')->toArray(), false);
    }

    public function test_create()
    {
        $this->get(route('users.create'))->assertOk()->assertSee('create-users');
    }

    public function test_store_users()
    {

        $data = [
            'name'      => 'Shani Indira',
            'email'     => 'shani@jkt48.com',
            'password'  => '12345678'
        ];

        $this->assertDatabaseEmpty('users');
        $this->assertDatabaseMissing('users', [
            'name'  => $data['name'],
            'email' => $data['email']
        ]);

        $this->post(route('users.store'), $data)
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name'  => $data['name'],
            'email' => $data['email']
        ]);
    }

    /**
     * @dataProvider dataTesting
     */
    public function test_store_validation_data($name, $email, $password, $errorKeys)
    {
        $this->post(route('users.store'), [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ])->assertSessionHasErrors($errorKeys);
    }

    public function dataTesting()
    {
        return [
            [null, null, null, ["name", "email", "password"]],
            ["Shania", null, null, ["email", "password"]],
            ["Shania", "shania@mail.com", null, ["password"]],
            ["Shania", "shania@mail.com", 123456, ["password"]],
            ["Shania", "shania@mail.com", 12345678, []],
            ["Shania", "shania", 12345678, ["email"]],
        ];
    }

    public function test_show_user_by_id()
    {
        $user = User::factory()->create();
        $this->get(route('users.show', ['user' => $user->id]))
            ->assertOk()
            ->assertSee($user->name, false);
    }

    public function test_show_user_not_found_in_database()
    {
        $this->get(route('users.show', ['user' => 1]))
            ->assertNotFound();
    }

    public function test_edit_user_by_id()
    {
        $user = User::factory()->create();
        $this->get(route('users.edit', ['user' => $user->id]))
            ->assertOk()
            ->assertSee($user->name, false);
    }

    public function test_edit_user_not_found_in_database()
    {
        $this->get(route('users.edit', ['user' => 1]))
            ->assertNotFound();
    }

    public function test_update_data()
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);

        $data = [
            'name' => 'Shania Gracia',
            'email' => 'shania@jkt48.com'
        ];

        $this->put(route('users.update', ['user' => $user->id]), $data)
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => $data['name']
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => $user->name
        ]);
    }

    /**
     * @dataProvider updateDataProvider
     */
    public function test_update_validation_data($name, $email, $password, $errorKeys)
    {
        $user = User::factory()->create();

        $this->put(route('users.update', ['user' => $user->id]), [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ])
            ->assertSessionHasErrors($errorKeys);
    }

    public function updateDataProvider()
    {
        return [
            [null, null, null, ["name", "email"]],
            ["test", null, null, ["email"]],
            [null, "email", null, ["name", "email"]],
            ["test", "email@mail.com", "1234567", ["password"]],
        ];
    }

    public function test_delete_data()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'name' => $user->name
        ]);

        $this->delete(route('users.destroy', ['user' => $user->id]))
            ->assertOk();

        $this->assertDatabaseMissing('users', [
            'id'    => $user->id,
            'name' => $user->name
        ]);
    }

    public function test_delete_missing_data()
    {
        $this->delete(route('users.destroy', ['user' => 1]))
            ->assertNotFound();
    }
}
