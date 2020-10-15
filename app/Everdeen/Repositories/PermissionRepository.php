<?php
/**
 * Created by PhpStorm.
 * User: Thang Nguyen
 * Date: 2017-06-08
 */

namespace Katniss\Everdeen\Repositories;


use Katniss\Everdeen\Models\Permission;
use Katniss\Everdeen\Utils\AppConfig;

class PermissionRepository extends ModelRepository
{
    public function getById($id)
    {
        return Permission::findOrFail($id);
    }

    public function getPaged()
    {
        return Permission::orderBy('created_at', 'desc')->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getSearchPaged($name = null)
    {
        $roles = Permission::orderBy('created_at', 'desc');
        
        if (!empty($name)) {
            $roles->where('name', 'like', '%' . $name . '%');
        }

        return $roles->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getAll()
    {
        return Permission::all();
    }

    public function getByHavingStatuses(array $statuses)
    {
        return Permission::haveStatuses($statuses)->get();
    }

    public function getByName($name)
    {
        return Permission::where('name', $name)->firstOrFail();
    }

    public function getByNames(array $names)
    {
        return Permission::whereIn('name', $names)->get();
    }

    public function getAllWithMapIdDisplayName()
    {
        return Permission::all()->pluck('display_name', 'id');
    }
}
