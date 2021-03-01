<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\AnnouncementInterface;

class Announcement extends Model
{


    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 1;
    
    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'active',
    ];


    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Create or update
     *
     * @param \App\Models\Api\AnnouncementInterface $announcementData
     * 
     * @return void
     */
    public function upsert(AnnouncementInterface $announcementData)
    {
        DB::transaction(function() use ($announcementData) {
            $me = $this;
            if ($id = $announcementData->getId()) {
                $me = $this->find($id);
            }
            
            $me->fill($announcementData->toArray());
            $me->save();
        });
    }

    /**
     * Get an announcements by end date
     *
     * @return \Illuminate\Support\Collection
     */
    public function onlyWithinEndDate()
    {
        $today = date('Y-m-d') . ' 23:59:59';

        return $this->where('end_date', '>', $today)->get();
    }

    /**
     * Auto activate or deactivate an announcements
     * based on start and end date
     *
     * @return void
     */
    public function autoActivateAndDeactivate()
    {
        $announcements = $this->onlyWithinEndDate();

        $foundIds = [];
        $container['to_activate'] = [];
        $container['to_deactivate'] = [];
        foreach($announcements as $announcement){
            $foundIds[] = $announcement->id;
            
            if ($announcement->start_date <= now()->__toString() && $announcement->end_date > now()->__toString()) {
                $container['to_activate'][] = $announcement->id;
            }

            if ($announcement->start_date <= now()->__toString() && $announcement->end_date < now()->__toString()) {
                $container['to_deactivate'][] = $announcement->id;
            }

            unset($announcement);
        }

        if (count($container['to_activate'])) {
            $me = new static();
            $me->whereIn('id', $container['to_activate'])->update([
                'active' => self::STATUS_ACTIVE,
                'updated_at' => now()->__toString(),
            ]);
        }

        if (count($container['to_deactivate'])) {
            $me = new static();
            $me->whereIn('id', $container['to_deactivate'])->update([
                'active' => self::STATUS_INACTIVE,
                'updated_at' => now()->__toString(),
            ]);
        }

        if (count($foundIds)) {
            $me = new static();
            $me->whereNotIn('id', $foundIds)->update([
                'active' => self::STATUS_INACTIVE,
                'updated_at' => now()->__toString(),
            ]);
        }

    }
}
