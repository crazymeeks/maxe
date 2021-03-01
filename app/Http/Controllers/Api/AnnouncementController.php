<?php

namespace App\Http\Controllers\Api;

use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Api\AnnouncementInterface;
use App\Http\Resources\AnnouncementResource;
use App\Http\Requests\Api\AnnouncementRequest;

class AnnouncementController extends Controller
{
    
    protected $_announcement;
    protected $_announcementData;
    
    /**
     * Constructor
     *
     * @param \App\Models\Announcement $announcement
     * @param \App\Models\Api\AnnouncementInterface $announcementInterface
     */
    public function __construct(Announcement $announcement, AnnouncementInterface $announcementData)
    {
        $this->_announcement = $announcement;
        $this->_announcementData = $announcementData;
    }

    public function listing()
    {
        return AnnouncementResource::collection(Announcement::orderBy('id', 'desc')->get());
    }

    /**
     * Create announcement
     *
     * @param \App\Http\Requests\Api\AnnouncementRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSave(AnnouncementRequest $request)
    {
        try {
            $this->_announcement->upsert($this->extractData($request));
            $code = $request->has('id') ? 200 : 201;
            return response()->json('Announcement saved successfully', $code);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json('Error while saving announcement. Please try again.', 400);
        }
    }

    /**
     * Delete an announcement
     * 
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        try {
            DB::transaction(function() use ($id) {
                Announcement::find($id)->delete();
            });
            return response()->json('Announcement successfully deleted!', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            response()->json('An error occured while deleting announcement. Please try again', 400);
        }
    }

    private function extractData(\Illuminate\Foundation\Http\FormRequest $request)
    {

        $this->_announcementData->setTitle($request->title)
                                     ->setContent($request->content)
                                     ->setStartDate($request->start_date)
                                     ->setEndDate($request->end_date)
                                     ->setStatus((int)$request->status);

        if ($request->has('id')) {
            $this->_announcementData->setId($request->id);
        }
        return $this->_announcementData;
    }
}
