<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DifferentOriginalName;
use App\Models\CarDatabase; 
use App\Models\Car;

class ListingCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $vinRegex = "regex:/^(?![O0Q])(?![I])(?!.*([A-HJ-NPR-Z0-9])\1{2})(?=(?:.*[A-HJ-NPR-Z]){1,})(?=(?:.*[0-9]){1,})[A-HJ-NPR-Z0-9]{17}$/";
        $colorRegex = "regex:/^[a-zA-Z]+(?:[-\\s][a-zA-Z]+)*$/";
        $currentYear = (int)date('Y'); 
        $imagesDifferrentFromMainImage = function ($attribute, $value, $fail) {
            if (request()->has('main-image')) {
                if (!app(\App\Rules\DifferentOriginalName::class, ['otherFile' => request()->file('main-image')])->passes($attribute, $value)) {
                    $fail(__('You cannot include your main car image here.'));
                }
            }
        };
        
        $makeModelYearValidationRule = function ($attribute, $value, $fail) {
            $make = request()->input('make');
            $model = request()->input('model');
            $year = request()->input('year');
    
            // Check if a car with the given make, model, and year exists
            $exists = CarDatabase::where('make', $make)
                ->where('model', $model)
                ->where('year', $year)
                ->exists();
            if (!$exists) {
                $fail(__('The selected make, model, and year combination is invalid.'));
            }
        };

        return [
            'make' => ['required', $makeModelYearValidationRule],
            'model' => ['required', $makeModelYearValidationRule],
            'year' => ['required', 'integer', 'min:2010', "max:{$currentYear}", $makeModelYearValidationRule],
            'type' => ['required', 'string', 'in:ice,ev'],
            'body' => ['required', 'string', 'in:sedan,suv,hatchback,truck,convertible,coupe,van,wagon'],
            'mileage' => ['required', 'numeric', 'min:0', 'max:150000'],
            'vin' => ['required', $vinRegex, 'unique:cars,vin,NULL,id,deleted_at,NULL'],
            'cylinders' => ['in:null,3,4,6,8,12'],
            'engine-power' => ['required', 'numeric', 'min:50', 'max:2000'],
            'displacement' => ['numeric', 'min:0.8', 'max:12'],
            'battery-capacity' => ['numeric', 'min:10', 'max:200'],
            'transmission-type' => ['required', 'string', 'in:manual transmission,automatic transmission,cvt'],
            'drive-type' => ['required', 'string', 'in:awd,fwd,rwd,4wd'],
            'fuel-type' => ['required', 'string', 'in:gasoline,diesel,ethanol,electricity,hybrid'],
            'door-count' => ['required', 'integer', 'in:3,5'],
            'capacity' => ['required', 'integer', 'in:2,4,5,7'],
            'crashes' => ['required', 'in:1,null'],
            'crash-description' => ['string', 'min:4', 'max:50'],
            'bid-price' => ['required', 'integer', 'min:500', 'max:1000000'],
            'buy-price' => ['required', 'integer', 'min:500', 'gte:bid-price', 'max:5000000'],
            'days-to-sell' => ['required', 'integer', 'min:4', 'max:30'],
            'main-image' => ['required', 'mimes:png,jpg,jpeg,gif', 'max:3072', 'dimensions:ratio=4/3,min_width=640,min_height=480'],
            'images' => ['required', 'array', 'min:2', 'max:9'],
            'images.*' => ['mimes:png,jpg,jpeg,gif','max:3072','dimensions:ratio=4/3,min_width=640,min_height=480',$imagesDifferrentFromMainImage],
        ];

    }

    public function messages(): array
    {
        return [
            'make' => [
                'required' => __('The make field is required.'),
            ],
            'model' => [
                'required' => __('The model field is required.'),
            ],
            'year' => [
                'required' => __('The year field is required.'),
                'integer' => __('The year must be an integer.'),
                'min' => __('The year must be at least :min.'),
                'max' => __('The year may not be greater than :max.'),
            ],
            'type' => [
                'required' => __('The type field is required.'),
                'string' => __('The type must be a string.'),
                'in' => __('The selected type is invalid.'),
            ],
            'body' => [
                'required' => __('The body field is required.'),
                'string' => __('The body must be a string.'),
                'in' => __('The selected body is invalid.'),
            ],
            'mileage' => [
                'required' => __('The mileage field is required.'),
                'numeric' => __('The mileage must be a number.'),
                'min' => __('The mileage must be at least :min.'),
                'max' => __('The mileage may not be greater than :max.'),
            ],
            'vin' => [
                'required' => __('The VIN field is required.'),
                'regex' => __('Invalid VIN format. Must be 17 characters, including uppercase letters and numbers.'),
                'unique' => __('This VIN has already been registered.')
            ],
            'cylinders' => [
                'in' => __('The selected cylinders is invalid.'),
            ],
            'engine-power' => [
                'required' => __('The engine power field is required.'),
                'numeric' => __('The engine power must be a number.'),
                'min' => __('The engine power must be at least :min.'),
                'max' => __('The engine power may not be greater than :max.'),
            ],
            'displacement' => [
                'numeric' => __('The displacement must be a number.'),
                'min' => __('The displacement must be at least :min.'),
                'max' => __('The displacement may not be greater than :max.'),
            ],
            'battery-capacity' => [
                'numeric' => __('The battery-capacity value must be a number.'),
                'min' => __('The selected battery-capacity must be at least :min kWh.'),
                'max' => __('The selected battery-capacity may not be greater than :max kWh.'),
            ],
            'transmission-type' => [
                'required' => __('The transmission type field is required.'),
                'string' => __('The transmission type must be a string.'),
                'in' => __('The selected transmission type is invalid.'),
            ],
            'drive-type' => [
                'required' => __('The drive type field is required.'),
                'string' => __('The drive type must be a string.'),
                'in' => __('The selected drive type is invalid.'),
            ],
            'fuel-type' => [
                'required' => __('The fuel type field is required.'),
                'string' => __('The fuel type must be a string.'),
                'in' => __('The selected fuel type is invalid.'),
            ],
            'door-count' => [
                'required' => __('The door count field is required.'),
                'integer' => __('The door count must be an integer.'),
                'in' => __('The selected door count is invalid.'),
            ],
            'capacity' => [
                'required' => __('The capacity field is required.'),
                'integer' => __('The capacity must be an integer.'),
                'in' => __('The selected capacity is invalid.'),
            ],
            'crashes' => [
                'required' => __('The crashes field is required.'),
                'in' => __('The selected crashes value is invalid.'),
            ],
            'crash-description' => [
                'string' => __('The crash description must be a string.'),
                'min' => __('The crash description must be at least :min characters.'),
                'max' => __('The crash description may not be greater than :max characters.'),
            ],
            'ext-color' => [
                'required' => __('The exterior color field is required.'),
                'string' => __('The exterior color must be a string.'),
                'min' => __('The exterior color must be at least :min characters.'),
                'max' => __('The exterior color may not be greater than :max characters.'),
                'regex' => __('The exterior color format is invalid. It should consist of lowercase letters with optional hyphens or spaces.'),
            ],
            'int-color' => [
                'required' => __('The interior color field is required.'),
                'string' => __('The interior color must be a string.'),
                'min' => __('The interior color must be at least :min characters.'),
                'max' => __('The interior color may not be greater than :max characters.'),
                'regex' => __('The interior color format is invalid. It should consist of lowercase letters with optional hyphens or spaces.'),
            ],
            'bid-price' => [
                'required' => __('The starting bid price field is required.'),
                'integer' => __('The starting bid price must be an integer.'),
                'min' => __('The starting bid price must be at least :min$.'),
                'max' => __('The starting bid price may not be greater than :max$.'),
            ],
            'buy-price' => [
                'required' => __('The starting buy price field is required.'),
                'integer' => __('The starting buy price must be an integer.'),
                'min' => __('The starting buy price must be at least :min$.'),
                'gte' => __('The Buy Price must be greater than or equal to the Bid Price.'),
                'max' => __('The starting buy price may not be greater than :max$.'),
            ],
            'days-to-sell' => [
                'required' => __('The days to sell field is required.'),
                'integer' => __('The days to sell must be an integer.'),
                'min' => __('The days to sell must be at least :min.'),
                'max' => __('The days to sell may not be greater than :max.'),
            ],
            'main-image' => [
                'required' => __('The main-image field is required.'),
                'mimes' => __('The main image must be a PNG, JPG, JPEG, or GIF file.'),
                'max' => __('The main image may not be greater than :max kilobytes.'),
                'dimensions' => __('The :attribute must have a minimum width of 640px, height of 480px while maintaining a 4:3 aspect ratio.'),
            ],
            'images' => [
                'required' => __('The images field is required.'),
                'array' => __('The images must be an array.'),
                'min' => __('You should introduce at least :min images.'),
                'max' => __('You can introduce max :max images.')
            ],
            'images.*.mimes' => __('Each image must be a file of type: :values.'),
            'images.*.max' => __('Each image may not be greater than :max kilobytes in size.'),
            'images.*.dimensions' => __('Each image has to be at least 640px in width, 480px in height and maintan a 4:3 aspect ratio'),
        ];
    }
}