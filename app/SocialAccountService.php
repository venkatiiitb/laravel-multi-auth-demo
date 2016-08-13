<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    /*
     * Create or Gets User if exists
     */
    public function createOrGetUser(ProviderUser $providerUser, $provider)
    {

        $account = SocialAccount::whereProvider($provider)
                    ->whereProviderUserId($providerUser->getId())
                    ->first();

        if ($account) {

            return $account->user;

        } else {

            $account = new SocialAccount([
                'provider_user_id'  => $providerUser->getId(),
                'provider'          => $provider
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}