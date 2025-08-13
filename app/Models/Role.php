<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
{
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => "Role was created",
                    'updated' => "Role details were updated",
                    'deleted' => "Role was deleted",
                    default => "Role was {$eventName}",
                };
            })
            ->useLogName('role')
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function syncPermissions(...$permissions)
    {
        $oldPermissions = $this->permissions->pluck('name')->toArray();
        $result = parent::syncPermissions(...$permissions);
        $newPermissions = $this->permissions->pluck('name')->toArray();

        $added = array_diff($newPermissions, $oldPermissions);
        $removed = array_diff($oldPermissions, $newPermissions);

        if (!empty($added)) {
            activity()
                ->performedOn($this)
                ->withProperties([
                    'added_permissions' => $added,
                    'removed_permissions' => $removed
                ])
                ->event('permissions_updated')
                ->log('Permissions updated for role');
                
        }

        return $result;
    }
}