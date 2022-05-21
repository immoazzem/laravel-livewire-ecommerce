<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Models\Cart as ModelsCart;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Session\SessionManager;
use PhpParser\Node\Expr\Variable;

Class Cart implements CartInterface
{
    protected $instance;

    public function __construct(protected SessionManager $session) { }

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function create(?User $user = null)
    {
        $instance = ModelsCart::make();
        // dd($instance);
        if ($user) {
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid);
    }

    public function add(Variation $variation, int $quantity = 1)
    {
        if ($existingVariation = $this->getVariation($variation)) {
            $quantity += $existingVariation->pivot->quantity;
        }


        $this->instance()->variations()->syncWithoutDetaching([
            $variation->id => [
                'quantity' => min($quantity, $variation->stockCount()),
            ],
        ]);
    }

    public function changeQuantity(Variation $variation, $quantity)
    {
        $this->instance()->variations()->updateExistingPivot($variation->id, [
            'quantity' => min($quantity, $variation->stockCount()),
        ]);
    }

    public function remove(Variation $variation)
    {
        $this->instance()->variations()->detach($variation);
    }

    public function isEmpty()
    {
        return $this->contents()->count() === 0;
    }

    public function getVariation(Variation $variation)
    {
        return $this->instance()->variations->find($variation->id);
    }

    public function contents()
    {
        return $this->instance()->variations;
    }

    public function contentsCount()
    {
        return $this->contents()->count();
    }

    public function subtotal()
    {
        return $this->instance()->variations
        ->reduce(function ($carry, $variation){
            return $carry ($variation->price * $variation->pivot->quantity);
        });
    }

    public function formattedSubtotal()
    {

    }

    protected function instance()
    {
        if($this->instance){
            return $this->instance;
        }
         return $this->instance = ModelsCart::query()
            ->with(
                'variations.product',
                'variations.ancestorsAndSelf',
                'variations.descendantsAndSelf.stocks',
                'variations.media'
            )
            ->whereUuid($this->session->get(config('cart.session.key')))
            ->first();
    }
}