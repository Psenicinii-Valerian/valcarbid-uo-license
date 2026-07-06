<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**xa
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $properNounRegex = "regex:/^([A-Z][a-z]*|Mc[A-Z][a-z]*)(?:[.\-\s]{1,2}[A-Z][a-z]*)*$/";

        $stateValidationRule = function ($attribute, $value, $fail) {
            if (!State::where('id', $value)->exists()) {
                $fail(__('The selected state is invalid.'));
            }
        };

        $cityValidationRule = function ($attribute, $value, $fail) use ($input) {
            if (!City::where('id', $value)
                ->where('state_id', $input['state'])
                ->exists()) {
                $fail(__('The selected city is invalid or does not match the state.'));
            }
        };

        // !!!!!new mail regex: 
        // ^(?:[a-zA-Z0-9._%+-]+@(?:gmail\.com|outlook\.com|yahoo\.com|aol\.com|icloud\.com|protonmail\.com|zoho\.com|gmx\.com|yandex\.com|mail\.com|mail\.ru|tutanota\.com|fastmail\.com|hushmail\.com|runbox\.com))$

        Validator::make($input, [
            'name' => ['required', 'min:3', 'max:255', $properNounRegex],
            'surname' => ['required', 'min:3', 'max:255', $properNounRegex],
            'email' => ['required', 'min:10', 'max:255', 'regex:/^(.+)@(.+)\.(.+)$/', 'unique:users'],
            'phone' => ['required', 'regex:/^[1-9]\d{9}$/', 'unique:users'],
            'state' => ['required', $stateValidationRule],
            'city' => ['required', $cityValidationRule],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ],
        [
            "name.required" => __("Please provide your name."),
            "name.min" => __("Your name must be at least 3 characters long."),
            "name.max" => __("Your name cannot exceed 255 characters."),
            "name.regex" => __("Your name must start with an uppercase letter, followed by lowercase letters, and may include periods, or spaces between words."),

            "surname.required" => __("Please provide your surname."),
            "surname.min" => __("Your surname must be at least 3 characters long."),
            "surname.max" => __("Your surname cannot exceed 255 characters."),
            "surname.regex" => __("Your surname must start with an uppercase letter, followed by lowercase letters, and may include periods, or spaces between words."),

            "email.required" => __("Please enter your email address."),
            "email.min" => __("Your email address must be at least 10 characters long."),
            "email.max" => __("Your email address cannot exceed 255 characters."),
            "email.regex" => __("Please enter a valid email address."),
            "email.unique" => __("This email has already been registered."),

            "phone.required" => __("Please provide your phone number."),
            "phone.regex" => __("Phone number must consist of exactly 10 digits."),
            "phone.unique" => __("This phone number has already been registered."),

            "state.required" => __("Please provide your state."),

            "city.required" => __("Please provide your city."),

            "password.required" => __("Please enter a password."),

            "terms.accepted" => __("You must accept the terms and conditions."),
            "terms.required" => __("Please accept the terms and conditions."),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'state' => $input['state'],
            'city' => $input['city'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
