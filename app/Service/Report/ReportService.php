<?php

namespace App\Service\Holiday;

use App\Models\Leave\Holiday\Holiday;
use App\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class HolidayService extends Service
{
    protected $report;

    public function __construct(Holiday $report)
    {
        $this->report = $report;

    }


    /*For DataTable*/
    public function getAllData()
    {
        $query = $this->report->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editcolumn('actions',function(Holiday $report) {
                $editRoute =  route('holiday.edit',$report->id);
                $deleteRoute =  route('holiday.destroy',$report->id);
                return getTableHtml($report,'actions',$editRoute,$deleteRoute);
            })->make(true);
    }

    public function create(array $data)
    {
        try {

            $report = $this->report->create($data);
            return $report;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all User
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->report->orderBy('id','DESC')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->report->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($reportId)
    {
        try {
            return $this->report->find($reportId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($reportId, array $data)
    {
        try {
            $report= $this->report->find($reportId);
            $report = $report->update($data);
            //$this->logger->info(' created successfully', $data);

            return $report;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a User
     *
     * @param Id
     * @return bool
     */
    public function delete($reportId)
    {
        try {


            $report = $this->report->find($reportId);
            return $report = $report->delete();

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->report->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->report->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/report';
            return $fileName = $this->uploadFromAjax($file);
        }
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

    public function updateImage($reportId, array $data)
    {
        try {
            $report = $this->report->find($reportId);
            $report = $report->update($data);

            return $report;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}

