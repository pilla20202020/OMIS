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
    protected $holidaytypes;

    public function __construct(Holiday $holidaytypes)
    {
        $this->holidaytypes = $holidaytypes;

    }


    /*For DataTable*/
    public function getAllData()
    {
        $query = $this->holidaytypes->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editcolumn('actions',function(Holiday $holidaytypes) {
                return '<a  href="' . route('holiday.edit',$holidaytypes->id) . '"><i class="fas fa-edit custom_edit" data-id=""></i></a>
                <a  href="' . route('leave.holiday.destroy',$holidaytypes->id) . '"><i class="fas fa-trash" data-id=""></i></a>
                ';

            })->rawColumns(['is_approved','actions'])->make(true);
    }

    /*For Dashboard*/
    public function getAllHoliday()
    {
        $query = $this->holidaytypes->get();
        return $query;
    }

    /*For Calender*/
    public function getUpcomingHoliday()
    {
        $query = $this->holidaytypes->whereDate('date', '>', Carbon::now())->take(1)->get();
        return $query;
    }

    public function create(array $data)
    {
        try {
            $data['created_by']= Auth::user()->id;
            $data['updated_by']= Auth::user()->id;
            $holidaytypes = $this->holidaytypes->create($data);
            return $holidaytypes;

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

        return $this->holidaytypes->orderBy('id','DESC')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->holidaytypes->pluck('date')->get();
    }


    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($holidaytypesId)
    {
        try {
            return $this->holidaytypes->find($holidaytypesId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($holidaytypesId, array $data)
    {
        try {
            $holidaytypes= $this->holidaytypes->find($holidaytypesId);
            $data['updated_by']= Auth::user()->id;
            $holidaytypes = $holidaytypes->update($data);
            //$this->logger->info(' created successfully', $data);

            return $holidaytypes;
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
    public function delete($holidaytypesId)
    {
        try {
            $holidaytypes = $this->holidaytypes->find($holidaytypesId);
            return $holidaytypes = $holidaytypes->delete();

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
        return $this->holidaytypes->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->holidaytypes->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/holidaytypes';
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

    public function updateImage($holidaytypesId, array $data)
    {
        try {
            $holidaytypes = $this->holidaytypes->find($holidaytypesId);
            $holidaytypes = $holidaytypes->update($data);

            return $holidaytypes;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}

