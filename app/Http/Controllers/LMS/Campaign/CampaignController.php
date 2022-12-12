<?php

namespace App\Http\Controllers\LMS\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\CampaignRequest;
use App\Models\LMS\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $campaign;

    function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }
    public function index()
    {
        //
        $campaigns = $this->campaign->orderBy('created_at', 'desc')->get();
        return view('backend.lms.campaign.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.lms.campaign.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        //

        // foreach($request->offered_course as $course)
        // {
        //     $result = $course;
        // }
        try {
            if ($campaign = $this->campaign->create($request->data())) {
                $campaign->fill([
                    'url' => Str::slug($request->name),
                    'alias' => Str::slug($request->name),
                ])->save();
                if ($request->hasFile('banner')) {
                    $this->uploadFile($request, $campaign,'banner');
                }

                if ($request->hasFile('ogImage')) {
                    $this->uploadFile($request, $campaign,'ogImage');
                }
            }
        } catch (Exception $e) {
            return null;
        }

        return redirect()->route('lms.campaign.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $campaign = $this->campaign->where('id',$id)->first();
        $campaign_course = explode(',', $campaign->offered_course);
        $ogtags = explode(',', $campaign->ogtags);
        $keywords = explode(',', $campaign->keywords);
        return view('backend.lms.campaign.edit', compact('campaign','campaign_course','keywords','ogtags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        //
        if ($campaign->update($request->data())) {
            $campaign->fill([
                'url' => Str::slug($request->name),
                'alias' => Str::slug($request->name),
            ])->save();
        }

        return redirect()->route('lms.campaign.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $campaign = $this->campaign->where('id',$id)->first();
        $campaign->delete();
        Toastr()->success('Campaign Deleted Successfully','Success');
        return redirect()->route('campaign.index');
    }

    function uploadFile(Request $request, $campaign, $type = null)
    {
        if ($type == 'banner') {
            $file = $request->file('banner');
            $path = 'uploads/campaign';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($campaign->banner))
                $this->__deleteImages($campaign);
            $data['banner'] = $fileName;
        }
        if ($type == 'ogImage') {
            $file = $request->file('ogImage');
            $path = 'uploads/campaign';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($campaign->banner))
                $this->__deleteImages($campaign);
            $data['ogImage'] = $fileName;
        }
        $this->updateImage($campaign->id, $data);

    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);
        } catch (\Exception $e) {

        }
    }

    public function updateImage($campaignId, array $data)
    {
        try {
            $campaign = $this->campaign->find($campaignId);
            $campaign = $campaign->update($data);
            return $campaign;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }


}
