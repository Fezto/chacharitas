<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): User
    {
// Validar la entrada
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'second_last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required', 'same:password'],
            'street' => ['required', 'string', 'max:255'],
            'state_id' => ['required', 'exists:states,id'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'neighborhood_id' => ['required', 'exists:neighborhoods,id'],
            'postal_code' => ['required', 'regex:/^\d{5}$/'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

// Crear la dirección
        $address = Address::create([
            'street' => $input['street'],
            'neighborhood_id' => $input['neighborhood_id'],
            'street_number' => $input['street_number'],
            'unit_number' => $input['unit_number']
        ]);

        /** @var User $user */
        $user = User::create([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'second_last_name' => $input['second_last_name'],
            'email' => $input['email'],
            'phone_number' => fake()->phoneNumber(),
            'password' => Hash::make($input['password']),
            'address_id' => $address->id,
        ]);

        return $user;
    }
}
