<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Announcement;
use App\Models\Api\AnnouncementInterface;

class AnnouncementControllerTest extends \Tests\TestCase
{


    public function testGetAnnouncements()
    {
        
        factory(Announcement::class)->create();
        $response = $this->json('GET', route('api.announcement.listing'), [], $this->getAccessToken());

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $response->original);
    }

    /**
     * @dataProvider data
     *
     * @return void
     */
    public function testCreateAnnouncement(array $data)
    {
        $response = $this->json('POST', route('api.save.announcement'), $data, $this->getAccessToken());
        $response->assertStatus(201);
        $this->assertDatabaseHas('announcements', [
            AnnouncementInterface::TITLE => 'Test',
            AnnouncementInterface::CONTENT => '<p>Content</p>',
        ]);
        
    }

    /**
     * @dataProvider data
     *
     * @return void
     */
    public function testUpdateAnnouncement(array $data)
    {
        factory(Announcement::class)->create();

        $data['id'] = 1;
        $response = $this->json('POST', route('api.save.announcement'), $data, $this->getAccessToken());
        $response->assertStatus(200);
        $this->assertEquals(1, Announcement::count());
    }

    public function testDeleteAnnouncement()
    {
        factory(Announcement::class)->create();

        $response = $this->json('DELETE', route('api.delete.announcement', ['id' => 1]), [], $this->getAccessToken());

        $response->assertStatus(200);
        $this->assertSame('Announcement successfully deleted!', $response->original);
    }

    /**
     * @dataProvider data
     *
     * @return void
     */
    public function testActivateAnnouncementBasedOnDate(array $data)
    {
        $response = $this->json('POST', route('api.save.announcement'), $data, $this->getAccessToken());
        $response->assertStatus(201);
        $this->assertDatabaseHas('announcements', [
            'active' => Announcement::STATUS_ACTIVE
        ]);
    }

    public function data()
    {
        $data = [
            'title' => 'Test',
            'content' => '<p>Content</p>',
            'start_date' => now()->__toString(),
            'end_date' => now()->__toString(),
            'status' => Announcement::STATUS_INACTIVE
        ];

        return [
            array($data)
        ];
    }
}