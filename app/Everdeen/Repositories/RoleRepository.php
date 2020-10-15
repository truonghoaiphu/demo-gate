<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-04
 * Time: 23:44
 */

namespace Katniss\Everdeen\Repositories;


use Katniss\Everdeen\Models\Role;
use Katniss\Everdeen\Utils\AppConfig;

class RoleRepository extends ModelRepository
{
    public function getById($id)
    {
        return Role::findOrFail($id);
    }

    public function getPaged()
    {
        return Role::orderBy('created_at', 'desc')->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getSearchPaged($name = null, array $permissions = null)
    {
        $roles = Role::orderBy('created_at', 'desc');
        
        if (!empty($name)) {
            $roles->where('name', 'like', '%' . $name . '%');
        }

        if (!empty($permissions)) {
            $roles->whereHas('perms', function($query) use ($permissions) {
                $query->whereIn('id', $permissions);
            });
        }

        return $roles->paginate(AppConfig::DEFAULT_ITEMS_PER_PAGE);
    }

    public function getAll()
    {
        return Role::all();
    }

    public function getByHavingStatuses(array $statuses)
    {
        return Role::haveStatuses($statuses)->get();
    }

    public function getByName($name)
    {
        return Role::where('name', $name)->firstOrFail();
    }

    public function getByNames(array $names)
    {
        return Role::whereIn('name', $names)->get();
    }

    /**
     * Get all role and return set of roles with mapping role id and role display name
     * @author thang.nguyen@antoree.com
     * @return Collection
     */
    public function getAndMapIdDisplayName()
    {
        return Role::select('id', 'display_name')->pluck('display_name', 'id');
    }

    /**
     * Delete a role
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
    public function delete($id)
    {
        $role = Role::findOrFail($id);

        return $role->delete();
    }

    /**
     * Create a role
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
    public function create(array $data, array $permissions = null)
    {
        $role = Role::create($data);

        if (!empty($permissions)) {
            if (count($permissions) > 0) {
                $role->perms()->attach($permissions);
            }
        }

        return $role;
    }

    /**
     * Update a role
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
    public function update($id, array $data, array $permissions = null)
    {
        $role = Role::findOrFail($id);

        $role->update($data);

        if (!empty($permissions)) {
            if (count($permissions) > 0) {
                $role->perms()->sync($permissions);
            }
        }

        return $role;
    }
    /**
     * Get all role
     * @author Thang.Nguyen <thang.nguyen@antoree.com>
     */
}