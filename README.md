# Sample Laravel Project

### API Routes
![api-routes](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/api.png?raw=true)

### Model
![food-model](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/food.png?raw=true)


### Controller
![controller](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/controller_1.png?raw=true)

![controller](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/controller_2.png?raw=true)

```php

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/* Handle food crud */

class FoodController extends Controller
{
    /**
     * Return all available foods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Food::all();
    }

    /**
     * Store a newly created food in storage.
     *
     * @param  \App\Http\Requests\CreateFoodRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFoodRequest $request)
    {
        /* Create a food instance without saving it to DB */
        $food = Food::make($request->all());

        /* Set User id */
        $food->user_id = Auth::user()->id;

        /* Store food picture if posted & update the food */
        if ($request->pic) {
            $food->update([
                'pic' => $request->pic->storeAs('food/pics', $food->id . '--' . Str::uuid()),
            ]);
        }

        /* Return created food in response */
        return $food;
    }

    /**
     * Get the specified food.
     *
     * @param  Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Food $food)
    {
        return $food;
    }

    /**
     * Update the specified food.
     *
     * @param  \Illuminate\Http\UpdateFoodRequest  $request
     * @param  Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        /* Check if user owns the food */
        if ($food->user_id !== Auth::id() && !Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'شما نمیتوانید این غذا را ویرایش کنید'
            ], 403);
        }

        /* Update fields in db */
        $food->update($request->all());


        /* Store new food picture if posted & update the food */
        if ($request->file('pic')) {
            $oldPic = $food->pic;
            /* Update new pic */
            if ($food->update(['pic' => $request->pic->storeAs('food/pics', $food->id . '--' . Str::uuid())])) {
                /* Delete old pic if new pic stored successfully */
                Storage::delete($oldPic);
            }
        }

        /* Return updated food in response */
        return $food;
    }

    /**
     * Destroy the specified food.
     *
     * @param  Food $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        return response($food->delete(), 204);
    }
}


```

### [Check out the `FoodController.php`](https://github.com/sizata-siege/sample-laravel/blob/main/app/Http/Controllers/FoodController.php)


### Create & Update Requests & Validation
![create-request](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/create.png?raw=true)

![update-request](https://github.com/sizata-siege/sample-laravel/blob/main/storage/docs/update.png?raw=true)
