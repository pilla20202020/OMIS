<?php

namespace App\Service\LeaveTypes;

use App\Models\Leave\LeaveTypes\LeaveTypes;
use App\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class LeaveTypesService extends Service
{
    protected $leavetypes;

    public function __construct(LeaveTypes $leavetypes)
    {
        $this->leavetypes = $leavetypes;

    }


    /*For DataTable*/
    public function getAllData()
    {
        $query = $this->leavetypes->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editcolumn('actions',function(LeaveTypes $leavetypes) {
                return '<a  href="' . route('leavetypes.edit',$leavetypes->id) . '"><i class="fas fa-edit custom_edit" data-id=""></i></a>
                <a  href="' . route('leave.leavetypes.destroy',$leavetypes->id) . '"><i class="fas fa-trash" data-id=""></i></a>
                ';
            })->rawColumns(['is_approved','actions'])->make(true);
    }

    public function create(array $data)
    {
        try {
            $leavetypes = $this->leavetypes->create($data);
            return $leavetypes;

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

        return $this->leavetypes->orderBy('id','DESC')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->leavetypes->get();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($leavetypesId)
    {
        try {
            return $this->leavetypes->find($leavetypesId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($leavetypesId, array $data)
    {
        try {
            $leavetypes= $this->leavetypes->find($leavetypesId);
            $leavetypes = $leavetypes->update($data);
            //$this->logger->info(' created successfully', $data);

            return $leavetypes;
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
    public function delete($leavetypesId)
    {
        try {


            $leavetypes = $this->leavetypes->find($leavetypesId);
            return $leavetypes = $leavetypes->delete();

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
        return $this->leavetypes->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->leavetypes->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/leavetypes';
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

    public function updateImage($leavetypesId, array $data)
    {
        try {
            $leavetypes = $this->leavetypes->find($leavetypesId);
            $leavetypes = $leavetypes->update($data);

            return $leavetypes;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}

