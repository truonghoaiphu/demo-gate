<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Broadcasting\Channel as BroadcastingChannel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\Storage\StoreFile;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends BaseUser
{
    use SoftDeletes, EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
    }
    use HasApiTokens, Notifiable;

    const AVATAR_FOLDER = 'profile_pictures';
    const AVATAR_THUMB_WIDTH = 250; // pixels
    const AVATAR_THUMB_HEIGHT = 250; // pixels

    const RELATION_FRIEND = 0;
    const RELATION_KID = 1;
    const RELATION_PARENT = 2;

    const EMAIL_VERIFIED_TRUE = 1;
    const EMAIL_VERIFIED_FALSE = 0;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_id',
        'channel_id',

        'name',
        'email',
        'alternate_email',
        'password',
        'display_name',
        'first_name',
        'last_name',
        'url_avatar',
        'url_avatar_thumb',

        'gender',
        'birth_day',

        'phone_code_id',
        'phone_number',
        'skype',

        'address',
        'city_id',
        'country_part_id',
        'country_state_id',
        'country_id',
        'nationality_id',
        'religion_id',

        'verification_code',
        'email_verified',
        'active',
        'remember_token',

        'meta',

        'old_id',

        'currentSubset',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'setting_id',
        'channel_id',
        'password',
        'verification_code',
        'active',
        'remember_token',
        'old_id',
    ];

    protected $dates = ['deleted_at'];

    #region Overridden
    public function receivesBroadcastNotificationsOn()
    {
        return new BroadcastingChannel($this->notificationChannel->code);
    }
    #endregion

    #region Attributes
    public function getOwnDirectoryAttribute()
    {
        $dir = StoreFile::userPath($this->id);
        StoreFile::checkDirectory($dir);
        return $dir;
    }

    public function getProfilePictureDirectoryAttribute()
    {
        $dir = StoreFile::userPath($this->id, self::AVATAR_FOLDER);
        StoreFile::checkDirectory($dir);
        return $dir;
    }

    public function getFormattedBirthDayAttribute()
    {
        return DateTimeHelper::getInstance()->shortDate($this->attributes['birth_day']);
    }

    public function getShownNameAttribute()
    {
        return empty($this->attributes['display_name']) ?
            $this->attributes['first_name'] . ' ' . $this->attributes['last_name'] : $this->attributes['display_name'];
    }

    public function getGenderNameAttribute()
    {
        return transGender($this->attributes['gender']);
    }

    public function getAgeAttribute()
    {
        return DateTimeHelper::getInstance()->diffYear($this->attributes['birth_day'], 'now');
    }

    public function getPhoneAttribute()
    {
        if (empty($this->attributes['phone_number'])) return '';

        $callingCode = empty($this->attributes['phone_code_id']) ? '' : $this->phoneCode->calling_code;
        return (empty($callingCode) ? '' : '(+' . $callingCode . ') ') . $this->attributes['phone_number'];
    }

    public function getMemberSinceAttribute()
    {
        return DateTimeHelper::getInstance()->shortDate($this->attributes['created_at']);
    }

    public function getCountConversationsAttribute()
    {
        return $this->conversations()->count();
    }

    public function getCountUnreadConversationsAttribute()
    {
        $conversations = $this->conversations()->wherePivot('read_at');
        $meta = $this->meta;
        if (!empty($meta['conversation_last_seen_at'])) {
            $conversations->whereHas('messages', function ($query) use ($meta) {
                $query->where('user_id', $this->attributes['id'])->where('created_at', '>=', $meta['conversation_last_seen_at']);
            });
        }

        return $conversations->count();
    }

    public function getCountReadConversationsAttribute()
    {
        return $this->conversations()->wherePivot('read_at', 'is not')->count();
    }

    public function getPermNamesAttribute()
    {
        $perms = [];
        foreach ($this->roles as $role) {
            foreach ($role->perms as $perm) {
                if (!in_array($perm->name, $perms)) {
                    $perms[] = $perm->name;
                }
            }
        }

        foreach ($this->teams as $team) {
            foreach ($team->role->perms as $perm) {
                if (!in_array($perm->name, $perms)) {
                    $perms[] = $perm->name;
                }
            }
        }

        return $perms;
    }

    public function getPermIdsAttribute()
    {
        $perms = [];
        foreach ($this->roles as $role) {
            foreach ($role->perms as $perm) {
                if (!in_array($perm->id, $perms)) {
                    $perms[] = $perm->id;
                }
            }
        }

        foreach ($this->teams as $team) {
            foreach ($team->role->perms as $perm) {
                if (!in_array($perm->id, $perms)) {
                    $perms[] = $perm->id;
                }
            }
        }

        return $perms;
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);
        return $meta === false ? [] : $meta;
    }

    public function setCurrentSubsetAttribute($value)
    {
        $meta = $this->meta;
        $meta['current_subset'] = empty($value) ? null : $value;
        $this->attributes['meta'] = json_encode($meta);
    }

    public function getCurrentSubsetAttribute()
    {
        $meta = $this->meta;
        return isset($meta['current_subset']) ? $meta['current_subset'] : null;
    }

    public function getShortTimeShortDateCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortTime', ' ', 'shortDate', $this->attributes['created_at']);
    }
    #endregion

    #region Relationships
    public function socialProviders()
    {
        return $this->hasMany(UserSocial::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users', 'user_id', 'role_id');
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class, 'id', 'setting_id');
    }

    public function notificationChannel()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channels_subscribers', 'user_id', 'channel_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversations_users', 'user_id', 'conversation_id');
    }

    public function teacherProfile()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }

    public function studentProfile()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function phoneCode()
    {
        return $this->belongsTo(Country::class, 'phone_code_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function countryState()
    {
        return $this->belongsTo(CountryState::class, 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id', 'id');
    }

    public function workingFields()
    {
        return $this->belongsToMany(WorkingField::class, 'users_working_fields', 'user_id', 'field_id');
    }

    public function specialistTrainings()
    {
        return $this->belongsToMany(SpecialistTraining::class, 'users_specialist_trainings', 'user_id', 'training_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'teams_users', 'user_id', 'team_id');
    }

    public function managingTeams()
    {
        return $this->hasMany(Team::class, 'managed_by', 'id');
    }

    public function certifications()
    {
        return $this->hasMany(UserCertification::class, 'user_id', 'id');
    }

    public function works()
    {
        return $this->hasMany(UserWork::class, 'user_id', 'id');
    }

    public function learningTopics()
    {
        return $this->belongsToMany(LearningTopic::class, 'teacher_target_topics', 'user_id', 'topic_id');
    }

    public function dashBoxes()
    {
        return $this->belongsToMany(DashBox::class, 'users_dash_boxes', 'user_id', 'dash_box_id');
    }

    public function subsets()
    {
        return $this->belongsToMany(Subset::class, 'users_subsets', 'user_id', 'subset_id');
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'attached_to', 'id');
    }

    public function childRelations()
    {
        return $this->belongsToMany(User::class, 'user_relations', 'main_id', 'related_id')
            ->withPivot('type');
    }

    public function parentRelations()
    {
        return $this->belongsToMany(User::class, 'user_relations', 'related_id', 'main_id');
    }
    #endregion

    #region Scopes
    public function scopeFromSocial($query, $provider, $provider_id, $email = null)
    {
        $query->whereExists(function ($query) use ($provider, $provider_id) {
            $query->select(DB::raw(1))
                ->from('user_socials')
                ->where('provider', $provider)->where('provider_id', $provider_id);
        });
        if (!empty($email)) {
            $query->orWhere('email', $email);
        }
        return $query;
    }
    #endregion

    #region Passport
    public function findForPassport($username)
    {
        $advanced = json_decode($username);
        if ($advanced !== false) {
            if (!empty($advanced->provider) && !empty($advanced->provider_id)) {
                $provider = $advanced->provider;
                $providerId = $advanced->provider_id;
                $user = User::whereHas('socialProviders', function ($query) use ($provider, $providerId) {
                    $query->where('provider', $provider)
                        ->where('provider_id', $providerId);
                })->first();
                if ($user) $user->_source = 'social';
                return $user;
            }
            if (!empty($advanced->token) && !empty($advanced->id)) {
                $sysToken = SysToken::where('type', SysToken::TYPE_LOGIN)
                    ->where('token', $advanced->token)->first();
                if (!empty($sysToken)) {
                    $sysToken->delete();
                    $user = User::where('id', $advanced->id)->orWhere('email', $advanced->id)->first();
                    if ($user) $user->_source = 'token';
                    return $user;
                }
            }
        }

        return User::where('email', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        $advanced = json_decode($password);
        if ($advanced !== false) {
            if (!empty($advanced->source) && !empty($this->_source)
                && $advanced->source == $this->_source) return true;
        }
        return Hash::check($password, $this->password);
    }
    #endregion

    #region Methods
    public function checkRole($roleName)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }

        return false;
    }
    #endregion
}
