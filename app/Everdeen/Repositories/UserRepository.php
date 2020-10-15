<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-04
 * Time: 23:44
 */

namespace Katniss\Everdeen\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Katniss\Everdeen\Exceptions\KatnissException;
use Katniss\Everdeen\Models\Channel;
use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\UserSetting;
use Katniss\Everdeen\Models\UserSocial;
use Katniss\Everdeen\Utils\AppConfig;
use Katniss\Everdeen\Utils\Storage\StorePhotoByCropperJs;

class UserRepository extends ModelRepository
{
    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function getByIdLoosely($id)
    {
        return User::find($id);
    }

    public function getPaged()
    {
        return User::orderBy('created_at', 'desc')->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getSearchPaged($displayName = null, $email = null, $country = null, $city = null, $gender = null, $countryPart = null, $religion = null, $birthYearMin = null, $birthYearMax = null, $phoneNumber = null, $skype = null, $address = null)
    {
        $users = User::with('roles')->orderBy('created_at', 'desc');
        $search = false;
        if (!empty($displayName) || !empty($email) || !empty($country) || !empty($city)
            || !empty($gender) || !empty($countryPart) || !empty($religion) ||
            !empty($birthYearMin) || !empty($birthYearMax) || !empty($phoneNumber)
            || !empty($skype) || !empty($address)
        ) {
            $search = true;
            if (!empty($displayName)) {
                $users->where('display_name', 'like', '%' . $displayName . '%');
            }
            if (!empty($email)) {
                $users->where('email', 'like', '%' . $email . '%');
            }
            if (!empty($country)) {
                $users->where('nationality_id', '=', $country);
            }

            if (!empty($city)) {
                $users->where('city_id', '=', $city);
            }

            if (!empty($gender)) {
                $users->where('gender', '=', $gender);
            }

            if (!empty($countryPart)) {
                $users->where('country_part_id', '=', $countryPart);
            }

            if (!empty($religion)) {
                $users->where('religion_id', '=', $religion);
            }

            if (!empty($birthYearMin) && !empty($birthYearMax)) {
                if ($birthYearMin == $birthYearMax) {
                    $users->whereYear('birth_day', intval($birthYearMin));
                } else {
                    $users->whereYear('birth_day', '>=', intval($birthYearMin))->whereYear('birth_day', '<=', intval($birthYearMax));
                }
            } else if (!empty($birthYearMin)) {
                $users->whereYear('birth_day', '>=', intval($birthYearMin));
            } else if (!empty($birthYearMax)) {
                $users->whereYear('birth_day', '<=', intval($birthYearMax));
            }

            if (!empty($phoneNumber)) {
                $users->where('phone_number', 'like', '%' . $phoneNumber . '%');
            }

            if (!empty($skype)) {
                $users->where('skype', 'like', '%' . $skype . '%');
            }

            if (!empty($address)) {
                $users->where('address', 'like', '%' . $address . '%');
            }
        }

        return $users->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getSearchCommonPaged($term = null)
    {
        $users = User::orderBy('created_at', 'desc');
        if (!empty($term)) {
            $users->where(function ($query) use ($term) {
                $query->where('id', $term)
                    ->orWhere('display_name', 'like', '%' . $term . '%')
                    ->orWhere('first_name', 'like', '%' . $term . '%')
                    ->orWhere('last_name', 'like', '%' . $term . '%')
                    ->orWhere('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('phone_number', 'like', '%' . $term . '%');
            });
        }
        return $users->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getAll()
    {
        return User::all();
    }

    public function getBySocial($provider, $providerId, $providerEmail)
    {
        return User::fromSocial($provider, $providerId, $providerEmail)->first();
    }

    public function getLikeName($name)
    {
        return User::where('name', 'like', $name . '%')->get();
    }

    public function existedEmail($email)
    {
        return User::where('email', $email)->count() > 0;
    }

    public function getByNameAndHashedPassword($name, $hashedPassword)
    {
        return User::where('name', $name)->where('password', $hashedPassword)->first();
    }

    protected function extractNameFromEmail($email)
    {
        $name = strtok($email, '@');
        $returnName = $name;
        $i = 0;

        while (User::where('name', '=', $returnName)->count() > 0) {
            $returnName = $name . (++$i);
        }

        return $returnName;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param int $phoneCodeId
     * @param string $phoneNumber
     * @param string $skype
     * @param string|null $avatar
     * @param string|null $provider
     * @param string|null $providerId
     * @return User
     * @throws KatnissException
     */
    public function createWhenRegisteringTeacher($firstName, $lastName,
                                                 $email, $password,
                                                 $phoneCodeId, $phoneNumber, $skype,
                                                 $avatar = null,
                                                 $provider = null, $providerId = null, $providerEmail = null)
    {
        DB::beginTransaction();
        try {
            $fromSocial = !empty($provider) && !empty($providerId);

            $settings = UserSetting::create();
            $channel = Channel::create([
                'type' => Channel::TYPE_NOTIFICATION
            ]);

            $user = User::create(array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'display_name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'name' => $this->extractNameFromEmail($email),
                'password' => Hash::make($password),
                'phone_code_id' => $phoneCodeId,
                'phone_number' => $phoneNumber,
                'skype' => $skype,
                'url_avatar' => empty($avatar) ? appDefaultUserProfilePicture() : $avatar,
                'url_avatar_thumb' => empty($avatar) ? appDefaultUserProfilePicture() : $avatar,
                'verification_code' => str_random(32),
                'active' => 1,
                'email_verified' => $fromSocial && $email == $providerEmail ? 1 : 0,
                'setting_id' => $settings->id,
                'channel_id' => $channel->id,
            ));

            $channel->subscribers()->attach($user->id);

            $user->attachRole((new RoleRepository())->getByName('teacher'));

            if ($fromSocial) {
                $user->socialProviders()->save(new UserSocial([
                    'provider' => $provider,
                    'provider_id' => $providerId,
                ]));
            }

            if ($user->email_verified == 0) {
                $user->sendRegisterNotification($password);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_insert') . ' (' . $ex->getMessage() . ')');
        }
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param int $phoneCodeId
     * @param string $phoneNumber
     * @param string $skype
     * @param string|null $avatar
     * @param string|null $provider
     * @param string|null $providerId
     * @return User
     * @throws KatnissException
     */
    public function createWhenRegisteringStudent($firstName, $lastName,
                                                 $email, $password,
                                                 $phoneCodeId, $phoneNumber,
                                                 $avatar = null,
                                                 $provider = null, $providerId = null, $providerEmail = null)
    {
        DB::beginTransaction();
        try {
            $fromSocial = !empty($provider) && !empty($providerId);

            $settings = UserSetting::create();
            $channel = Channel::create([
                'type' => Channel::TYPE_NOTIFICATION
            ]);

            $user = User::create(array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'display_name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'name' => $this->extractNameFromEmail($email),
                'password' => Hash::make($password),
                'phone_code_id' => $phoneCodeId,
                'phone_number' => $phoneNumber,
                'url_avatar' => empty($avatar) ? appDefaultUserProfilePicture() : $avatar,
                'url_avatar_thumb' => empty($avatar) ? appDefaultUserProfilePicture() : $avatar,
                'verification_code' => str_random(32),
                'active' => 1,
                'email_verified' => $fromSocial && $email == $providerEmail ? 1 : 0,
                'setting_id' => $settings->id,
                'channel_id' => $channel->id,
            ));

            $channel->subscribers()->attach($user->id);

            $user->attachRole((new RoleRepository())->getByName('student'));

            if ($fromSocial) {
                $user->socialProviders()->save(new UserSocial([
                    'provider' => $provider,
                    'provider_id' => $providerId,
                ]));
            }

            if ($user->email_verified == 0) {
                $user->sendRegisterNotification($password);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_insert') . ' (' . $ex->getMessage() . ')');
        }
    }

    /**
     * Alternate for create function
     *
     * @param array $attributes
     * @param array|null $roles
     * @param bool $sendWelcomeMail
     * @return User
     * @throws KatnissException
     */
    public function createWithAttributes(array $attributes, array $roles = [], array $settingAttributes = [], $sendRegisterNotification = false)
    {
        DB::beginTransaction();
        try {
            $settings = UserSetting::create($settingAttributes);
            $channel = Channel::create([
                'type' => Channel::TYPE_NOTIFICATION
            ]);

            $user = User::create(array_merge($attributes, [
                'password' => Hash::make($attributes['password']),
                'name' => $this->extractNameFromEmail($attributes['email']),
                'channel_id' => $channel->id,
                'setting_id' => $settings->id,
                'url_avatar' => appDefaultUserProfilePicture(),
                'url_avatar_thumb' => appDefaultUserProfilePicture(),
            ]));

            $channel->subscribers()->attach($user->id);

            if (count($roles) > 0) {
                $user->roles()->attach($roles);
            }

            if ($sendRegisterNotification) {
                $user->sendRegisterNotification($attributes['password']);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_insert') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updateWithAttributes(array $attributes, array $roles = null, $settingAttributes = [], $sendPasswordNotification = false)
    {

        $user = $this->model();

        DB::beginTransaction();
        try {
            if (!empty($settingAttributes)) {
                $user->settings->update($settingAttributes);
            }

            $passwordChanged = !empty($attributes['password']);
            if (!$passwordChanged) unset($attributes['password']);
            $user->update($passwordChanged ?
                array_merge($attributes, [
                    'password' => Hash::make($attributes['password']),
                ]) : $attributes
            );

            if (is_array($roles)) {
                if (count($roles) > 0) {
                    $hiddenRoles = $user->roles()->where('status', Role::STATUS_HIDDEN)->get();
                    if ($hiddenRoles->count() > 0) {
                        $hiddenRoles = $hiddenRoles->pluck('id')->all();
                        $roles = array_merge($roles, $hiddenRoles);
                    }
                    $user->roles()->sync($roles);
                } else {
                    $user->roles()->detach();
                }
            }

            if ($passwordChanged && $sendPasswordNotification) {
                $user->sendPasswordNotification($attributes['password']);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updatePassword($password, $sendPasswordNotification = false)
    {
        $user = $this->model();
        DB::beginTransaction();
        try {
            $user->password = Hash::make($password);
            $user->save();

            if ($sendPasswordNotification) {
                $user->sendPasswordNotification($password);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updateEmail($email)
    {
        $user = $this->model();
        DB::beginTransaction();
        try {
            if (strtolower($user->email) != strtolower($email)) {
                $user->email = $email;
                $user->email_verified = 0;
                $user->save();
            }

            $user->sendRegisterNotification('******');

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function notifyRegistration($email)
    {
        try {
            $user = User::where('email', $email)->first();
            $user->sendRegisterNotification('******');

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updateEmailVerified($verificationCode)
    {
        $user = $this->model();
        DB::beginTransaction();
        try {
            if ($user->verification_code == $verificationCode) {
                $user->email_verified = 1;
                $user->save();
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updateAvatarByCropperJs($imageRealPath, $imageCropData = null)
    {
        $user = $this->model();

        $urlAvatar = null;
        $urlAvatarThumb = null;

        try {
            $storePhoto = new StorePhotoByCropperJs($imageRealPath);
            $storePhoto->moveToUser($user->id, User::AVATAR_FOLDER);
            if ($imageCropData != null) {
                $storePhoto->process($imageCropData);
            }
            $urlAvatar = $storePhoto->getUrl();

            $storePhoto = $storePhoto->createThumbnail(User::AVATAR_THUMB_WIDTH, User::AVATAR_THUMB_HEIGHT);
            $urlAvatarThumb = $storePhoto->getUrl();
        } catch (\Exception $exception) {
            throw new KatnissException(null, KatnissException::APP_LEVEL, null, 0, $exception);
        }

        try {
            $user->url_avatar = $urlAvatar;
            $user->url_avatar_thumb = $urlAvatarThumb;
            $user->save();

            return $user;
        } catch (\PDOException $exception) {
            throw new KatnissException($exception->getMessage(), KatnissException::DATABASE_LEVEL, null, 0, $exception);
        } catch (\Exception $exception) {
            throw new KatnissException($exception->getMessage(), KatnissException::APP_LEVEL, null, 0, $exception);
        }
    }

    /**
     * Add Working fields
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
    public function attachWorkingField($workingFieldId)
    {
        $user = $this->model();
        $result = $user->workingFields()->syncWithoutDetaching([$workingFieldId]);
        return $result;
    }

    /**
     * Detach Working fields
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
    public function detachWorkingField($workingFieldId)
    {
        $user = $this->model();
        $result = $user->workingFields()->detach([$workingFieldId]);

        return $result;
    }

    public function createFacebookConnection($providerId, $avatar)
    {
        $user = $this->model();

        DB::beginTransaction();
        try {
            $user->socialProviders()->save(new UserSocial([
                'provider' => UserSocial::PROVIDER_FACEBOOK,
                'provider_id' => $providerId,
            ]));
            $user->url_avatar = $avatar;
            $user->url_avatar_thumb = $avatar;
            $user->save();

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_insert') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function removeFacebookConnection()
    {
        $user = $this->model();

        DB::beginTransaction();
        try {
            $user->socialProviders()
                ->where('provider', UserSocial::PROVIDER_FACEBOOK)
                ->delete();
            $user->url_avatar = appDefaultUserProfilePicture();
            $user->url_avatar_thumb = appDefaultUserProfilePicture();
            $user->save();

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function hasFacebookConnected()
    {
        $user = $this->model();
        return $user->socialProviders()
                ->where('provider', UserSocial::PROVIDER_FACEBOOK)
                ->count() > 0;
    }

    public function delete()
    {
        $user = $this->model();

        if ($user->id == authUser()->id) {
            throw new KatnissException(trans('error._cannot_delete', ['reason' => trans('error.is_current_user')]));
        }
        if ($user->hasRole('owner')) {
            throw new KatnissException(trans('error._cannot_delete', ['reason' => trans('error.is_role_owner')]));
        }

        try {
            $user->delete();
            return true;
        } catch (\Exception $ex) {
            throw new KatnissException(trans('error.database_delete') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function updateLocale($locale)
    {
        $user = $this->model();
        try {
            $settings = $user->settings;
            $settings->locale = $locale;
            $settings->save();

            return $user;
        } catch (\Exception $exception) {
            throw new KatnissException(trans('error.database_update') . ' (' . $exception->getMessage() . ')');
        }
    }

    /**
     * Update user settings
     *
     */
    public function updateUserSettings($settingData, $userId = null)
    {
        $user = $this->model($userId);

        try {
            $settings = $user->settings;
            $settings->update($settingData);

            return $user;
        } catch (\Exception $exception) {
            throw new KatnissException(trans('error.database_update') . ' (' . $exception->getMessage() . ')');
        }
    }

    /**
     * Update user info
     * @author Hieu
     */
//    public function updateEmail($email)
//    {
//        $user = $this->model();
//        try {
//            if (strtolower($user->email) != strtolower($email)) {
//                $user->email = strtolower($email);
//                $user->email_verified = 0;
//            }
//            $user->save();
//        } catch (\Exception $exception) {
//            throw new KatnissException(trans('error.database_update') . ' (' . $exception->getMessage() . ')');
//        }
//    }

    /**
     * Update user info
     * @author Hieu
     */
    public function updateUserInfo($infoData)
    {
        $user = $this->model();
        try {
            $user->name = $infoData['name'];
            $user->alternate_email = strtolower($infoData['alternate_email']);
            $user->skype = $infoData['skype'];
            $user->phone_code_id = $infoData['phone_code_id'];
            $user->phone_number = $infoData['phone_number'];
            $user->save();
            return $user;
        } catch (\Exception $exception) {
            throw new KatnissException(trans('error.database_update') . ' (' . $exception->getMessage() . ')');
        }
    }

    /**
     * Update user meta
     * @author Hieu
     */

    public function updateUserMeta($params)
    {
        $user = $this->model();
        try {
            $meta = json_decode("{}", true);
            if ($user->meta != null && $user->meta != "") {
                $meta = json_decode($user->meta, true);
            }

            foreach ($params as $key => $value) {
                $meta[$key] = $value;
            }
            $user->meta = json_encode($meta);
            $user->save();
            return $meta;
        } catch (\Exception $exception) {
            throw new KatnissException(trans('error.database_update') . ' (' . $exception->getMessage() . ')');
        }
    }

    /**
     * update contact info of members_home/setup
     * @author  Tai.Nguyen <tai.nguyen@antoree.com>
     * @param  string $firstName
     * @param  string $lastName
     * @param  int $gender
     * @param  $birthDay
     * @param  int $nationalityId
     * @return user|KanissException
     * @since  2017-06-15
     */
    public function updateSetupStep1($firstName, $lastName, $gender, $birthDay, $nationalityId)
    {
        $user = $this->model();
        DB::beginTransaction();

        try {
            $user->update(array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => $gender,
                'birth_day' => $birthDay,
                'nationality_id' => $nationalityId,
            ));

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new KatnissException(trans('error.database_update') . ' (' . $ex->getMessage() . ')');
        }
    }

    public function getByTeamId($teamId)
    {
        $users = User::whereHas('teams', function ($query) use ($teamId) {
            $query->where('teams.id', '=', $teamId);
        })->get();

        return $users;
    }

    /**
     * create user from contact
     * @param  String $name
     * @param  String $email
     * @param  String $phone
     * @param  String $skype
     * @return user
     */
    public function createFromContact($name = null, $email = null, $phone = null, $skype = null, $password = null)
    {
        DB::beginTransaction();
        try {
            $settings = UserSetting::create();
            $channel = Channel::create([
                'type' => Channel::TYPE_NOTIFICATION
            ]);

            $user = User::create([
                'display_name' => $name,
                'name' => $this->extractNameFromEmail($email),
                'email' => $email,
                'phone_number' => $phone,
                'skype' => $skype,
                'password' => Hash::make($password),
                'url_avatar' => appDefaultUserProfilePicture(),
                'url_avatar_thumb' => appDefaultUserProfilePicture(),
                'channel_id' => $channel->id,
                'setting_id' => $settings->id,
            ]);

            $channel->subscribers()->attach($user->id);

            if ($user->email_verified == 0) {
                $user->sendRegisterNotification($password);
            }

            DB::commit();

            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw new KatnissException(trans('error.database_insert') . ' (' . $ex->getMessage() . ')');
        }
    }

    /**
     * find user with email and phone
     * @author Hieu.Tran <hieu.tran@antoree.com>
     * @return user
     */
    public function findUser($email, $phone)
    {
        $email = mb_strtolower(trim($email));
        $phoneNumber = preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone));

        $stringQuery = '';
        $queryVariable = [
            $email,
            floatval($phoneNumber),
        ];
        if ($phoneNumber && $email) $stringQuery = 'LOWER(email) = ? or TrimZeroLeft(NumericOnly(phone_number)) = ?';
        elseif ($email) {
            $stringQuery = 'LOWER(email) = ?';
            $queryVariable = [
                $email,
            ];
        } elseif ($phoneNumber) {
            $stringQuery = 'TrimZeroLeft(NumericOnly(phone_number)) = ?';
            $queryVariable = [
                floatval($phoneNumber),
            ];
        }

        $currentUser = empty($stringQuery) ?
            null : User::whereRaw($stringQuery, $queryVariable)->first();

        return $currentUser;
    }
}