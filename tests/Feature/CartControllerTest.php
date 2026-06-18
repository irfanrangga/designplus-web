<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->product = Product::factory()->create([
            'harga' => 50000,
        ]);
    }

    // =========================================================================
    // index()
    // =========================================================================

    /** @test */
    public function index_redirects_unauthenticated_user()
    {
        $response = $this->get(route('cart'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function index_returns_cart_view_for_authenticated_user()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('cart'));

        $response->assertStatus(200);
        $response->assertViewIs('cart');
    }

    /** @test */
    public function index_passes_required_variables_to_view()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('cart'));

        $response->assertViewHasAll(['cartItems', 'subtotal', 'tax', 'total', 'discount']);
    }

    /** @test */
    public function index_calculates_correct_subtotal_for_standard_items()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 2,
            'custom_file' => 'Standard',
            'is_selected' => true,
        ]);

        $response = $this->get(route('cart'));

        // subtotal = 50000 * 2 = 100000
        $response->assertViewHas('subtotal', 100000);
    }

    /** @test */
    public function index_adds_custom_surcharge_of_5000_per_unit()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 1,
            'custom_file' => 'custom_uploads/some_file.png', // non-standard → custom
            'is_selected' => true,
        ]);

        $response = $this->get(route('cart'));

        // finalPrice = 50000 + 5000 = 55000; subtotal = 55000 * 1
        $response->assertViewHas('subtotal', 55000);
    }

    /** @test */
    public function index_calculates_tax_as_11_percent_of_subtotal()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 1,
            'custom_file' => 'Standard',
            'is_selected' => true,
        ]);

        $response = $this->get(route('cart'));

        $response->assertViewHas('tax', 50000 * 0.11);
    }

    /** @test */
    public function index_does_not_count_deselected_items_in_subtotal()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 3,
            'custom_file' => 'Standard',
            'is_selected' => false,
        ]);

        $response = $this->get(route('cart'));

        $response->assertViewHas('subtotal', 0);
    }

    /** @test */
    public function index_only_shows_cart_items_belonging_to_authenticated_user()
    {
        $this->actingAs($this->user);

        $otherUser = User::factory()->create();
        Cart::factory()->create(['user_id' => $otherUser->id, 'product_id' => $this->product->id]);
        Cart::factory()->create(['user_id' => $this->user->id,  'product_id' => $this->product->id]);

        $response = $this->get(route('cart'));

        $cartItems = $response->viewData('cartItems');
        $this->assertCount(1, $cartItems);
        $this->assertEquals($this->user->id, $cartItems->first()->user_id);
    }

    // =========================================================================
    // store()
    // =========================================================================

    /** @test */
    public function store_redirects_unauthenticated_user_to_login()
    {
        $response = $this->post(route('cart.store'), [
            'product_id' => $this->product->id,
            'material'   => 'Besi',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function store_validates_required_fields()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.store'), []);

        $response->assertSessionHasErrors(['product_id', 'material']);
    }

    /** @test */
    public function store_validates_product_id_must_exist()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.store'), [
            'product_id' => 99999,
            'material'   => 'Besi',
        ]);

        $response->assertSessionHasErrors(['product_id']);
    }

    /** @test */
    public function store_validates_quantity_min_1()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.store'), [
            'product_id' => $this->product->id,
            'material'   => 'Besi',
            'quantity'   => 0,
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /** @test */
    public function store_validates_quantity_max_9999()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.store'), [
            'product_id' => $this->product->id,
            'material'   => 'Besi',
            'quantity'   => 10000,
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /** @test */
    public function store_creates_new_cart_item_with_standard_file_path()
    {
        $this->actingAs($this->user);

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'quantity'    => 1,
            'design_type' => 'standard',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'custom_file' => 'Standard',
            'quantity'    => 1,
        ]);
    }

    /** @test */
    public function store_sets_custom_request_when_design_type_is_custom_without_file()
    {
        $this->actingAs($this->user);

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'quantity'    => 1,
            'design_type' => 'custom',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id'     => $this->user->id,
            'custom_file' => 'Custom Request',
        ]);
    }

    /** @test */
    public function store_uploads_file_and_stores_path_when_file_provided()
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('design.png');

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'custom_file' => $file,
        ]);

        $cart = Cart::where('user_id', $this->user->id)->first();
        $this->assertNotNull($cart);
        $this->assertStringStartsWith('custom_uploads/', $cart->custom_file);
        Storage::disk('public')->assertExists($cart->custom_file);
    }

    /** @test */
    public function store_rejects_disallowed_file_types()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream');

        $response = $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'custom_file' => $file,
        ]);

        $response->assertSessionHasErrors(['custom_file']);
    }

    /** @test */
    public function store_merges_quantity_when_duplicate_cart_item_exists()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'warna'       => null,
            'custom_file' => 'Standard',
            'quantity'    => 3,
        ]);

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'quantity'    => 2,
            'design_type' => 'standard',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 5,
        ]);
        $this->assertDatabaseCount('carts', 1);
    }

    /** @test */
    public function store_prevents_merged_quantity_exceeding_9999()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'warna'       => null,
            'custom_file' => 'Standard',
            'quantity'    => 9998,
        ]);

        $response = $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'quantity'    => 5,
            'design_type' => 'standard',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('carts', ['quantity' => 9998]); // unchanged
    }

    /** @test */
    public function store_creates_separate_cart_item_when_material_differs()
    {
        $this->actingAs($this->user);

        Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'material'    => 'Kayu',
            'custom_file' => 'Standard',
            'quantity'    => 1,
        ]);

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'quantity'    => 1,
            'design_type' => 'standard',
        ]);

        $this->assertDatabaseCount('carts', 2);
    }

    /** @test */
    public function store_redirects_to_cart_with_success_message_on_success()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
            'design_type' => 'standard',
        ]);

        $response->assertRedirect(route('cart'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function store_uses_quantity_1_as_default_when_not_provided()
    {
        $this->actingAs($this->user);

        $this->post(route('cart.store'), [
            'product_id'  => $this->product->id,
            'material'    => 'Besi',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id'  => $this->user->id,
            'quantity' => 1,
        ]);
    }

    // =========================================================================
    // update()
    // =========================================================================

    /** @test */
    public function update_validates_quantity_is_required()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create(['user_id' => $this->user->id, 'product_id' => $this->product->id]);

        $response = $this->patch(route('cart.update', $cart->id), []);

        $response->assertSessionHasErrors(['quantity']);
    }

    /** @test */
    public function update_validates_quantity_min_1()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create(['user_id' => $this->user->id, 'product_id' => $this->product->id]);

        $response = $this->patch(route('cart.update', $cart->id), ['quantity' => 0]);

        $response->assertSessionHasErrors(['quantity']);
    }

    /** @test */
    public function update_changes_quantity_for_cart_item()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'    => $this->user->id,
            'product_id' => $this->product->id,
            'quantity'   => 1,
        ]);

        $this->patch(route('cart.update', $cart->id), ['quantity' => 5]);

        $this->assertDatabaseHas('carts', ['id' => $cart->id, 'quantity' => 5]);
    }

    /** @test */
    public function update_returns_json_response_for_ajax_requests()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 1,
            'custom_file' => 'Standard',
        ]);

        $response = $this->patchJson(route('cart.update', $cart->id), ['quantity' => 3]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'item_total']);
    }

    /** @test */
    public function update_json_response_calculates_correct_item_total_for_standard_item()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 1,
            'custom_file' => 'Standard',
        ]);

        $response = $this->patchJson(route('cart.update', $cart->id), ['quantity' => 2]);

        // item_total = 50000 * 2 = 100000
        $response->assertJson(['item_total' => 100000]);
    }

    /** @test */
    public function update_json_response_adds_5000_surcharge_for_custom_item()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'     => $this->user->id,
            'product_id'  => $this->product->id,
            'quantity'    => 1,
            'custom_file' => 'custom_uploads/file.png',
        ]);

        $response = $this->patchJson(route('cart.update', $cart->id), ['quantity' => 2]);

        // item_total = (50000 + 5000) * 2 = 110000
        $response->assertJson(['item_total' => 110000]);
    }

    /** @test */
    public function update_returns_404_when_cart_item_belongs_to_another_user()
    {
        $this->actingAs($this->user);
        $otherUser = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id'    => $otherUser->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->patchJson(route('cart.update', $cart->id), ['quantity' => 2]);

        $response->assertStatus(404);
    }

    /** @test */
    public function update_redirects_back_for_non_ajax_requests()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'    => $this->user->id,
            'product_id' => $this->product->id,
            'quantity'   => 1,
        ]);

        $response = $this->patch(route('cart.update', $cart->id), ['quantity' => 4]);

        $response->assertRedirect();
    }

    // =========================================================================
    // destroy()
    // =========================================================================

    /** @test */
    public function destroy_deletes_cart_item_owned_by_authenticated_user()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'    => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $this->delete(route('cart.destroy', $cart->id));

        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    /** @test */
    public function destroy_does_not_delete_cart_item_belonging_to_another_user()
    {
        $this->actingAs($this->user);
        $otherUser = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id'    => $otherUser->id,
            'product_id' => $this->product->id,
        ]);

        $this->delete(route('cart.destroy', $cart->id));

        $this->assertDatabaseHas('carts', ['id' => $cart->id]);
    }

    /** @test */
    public function destroy_redirects_back_with_success_message()
    {
        $this->actingAs($this->user);
        $cart = Cart::factory()->create([
            'user_id'    => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->delete(route('cart.destroy', $cart->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function destroy_does_not_throw_when_cart_item_not_found()
    {
        $this->actingAs($this->user);

        // Non-existent ID — should not throw, just redirects back
        $response = $this->delete(route('cart.destroy', 99999));

        $response->assertRedirect();
    }

    /** @test */
    public function destroy_redirects_unauthenticated_user_to_login()
    {
        $cart = Cart::factory()->create([
            'user_id'    => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->delete(route('cart.destroy', $cart->id));

        $response->assertRedirect(route('login'));
    }
}