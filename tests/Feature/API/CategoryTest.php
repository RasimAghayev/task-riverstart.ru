<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryTest extends TestCase
{
    /**
     * Authenticate user.
     *
     * @return void
     */
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345,678910).'test@gmail.com',
            'password' => bcrypt('secret9874')
        ]);

        if (!auth()->attempt(['email'=>$user->email, 'password'=>'secret9874'])) {
            return response(['message' => 'Login credentials are invaild']);
        }
        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    /**
     * test create category.
     *
     * @return void
     */
    public function test_create_category()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/v1/category',[
            'name' => 'Test category',
            'description' => 'Test category',
            'parent_id' => 1,
        ])->assertStatus(200);
        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);
        return $response->getContent();
//        $response->assertStatus(200);
    }

    /**
     * test find category.
     *
     * @return void
     */
    public function test_list_category()
    {
        $token = $this->authenticate();
        $id = $this->test_create_category();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/v1/category');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find category.
     *
     * @return void
     */
    public function test_find_category()
    {
        $token = $this->authenticate();
        $id = (array) json_decode($this->test_create_category());
        $id=(int) $id['data']->id;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/v1/category/{$id}');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find category.
     *
     * @return void
     */
    public function test_update_category()
    {
        $token = $this->authenticate();
        $id = $this->test_create_category()->data->id;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','api/v1/category/{$id}',[
            'name' => 'Test category 2',
            'description' => 'Test category 2',
            'parent_id' => 2,
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
    /**
     * test delte category.
     *
     * @return void
     */
    public function test_delete_category()
    {
        $token = $this->authenticate();
        $id = $this->test_create_category()->id;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/v1/category/{$id}');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
