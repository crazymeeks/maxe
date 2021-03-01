<?php

namespace Tests\Unit;

use App\Models\Announcement;

class AutoActivateAnnouncementTest extends \Tests\TestCase
{

    private $_announcement;

    public function setUp(): void
    {
        parent::setUp();
        $this->_announcement = app(Announcement::class);

    }

    /**
     * @see \App\Console\Commands\AutoActivateAnnouncement for cron usage
     *
     * @return void
     */
    public function testActivateAnnouncements()
    {

        factory(Announcement::class)->create([
            'title' => 'Test',
            'content' => 'Test',
            'start_date' => now()->__toString(),
            'end_date' => date('Y-m-d H:i:s', strtotime(now()->__toString() . ' +1 day')),
            'active' => Announcement::STATUS_INACTIVE,
        ]);
        
        $this->_announcement->autoActivateAndDeactivate();
        $this->assertDatabaseHas('announcements', [
            'active' => Announcement::STATUS_ACTIVE
        ]);
        
    }
}