<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestMail;
use App\Models\Form\FormDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CommonFormController extends Controller
{
    public function create()
    {
        return view('backend.form.common.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        unset($data['_token']);
        $formData = [];
        foreach ($data['result'] as $key => $field) {
            if ($field['name'] == 'FormName') {
                $formData['form_name'] = $field['value'];
            }
            if ($field['name'] == 'LastValidDate') {
                $formData['last_valid_date'] = $field['value'];
            }
        }
        $formData['company_id'] = auth()->user()->company_id;
        // dd($data);
        $formData['form_detail'] = json_encode($data);
        $isExistForm = FormDetail::where('company_id', $formData['company_id'])->where('form_name', $formData['form_name'])->first();
        if ($isExistForm) {
            $isExistForm->update($formData);
        } else {
            FormDetail::create($formData);
        }

        return response()->json(['status' => 'Success'], 200);
    }

    public function getFormApplication($form_name)
    {
        // dd($form_name);
        $string = str_replace(" ", "-", $form_name);
        $string = strtolower($string);
        $company_id = auth()->user()->company_id;

        $formDetails = FormDetail::where('company_id', $company_id)->where('form_name', $form_name)->first();
        // dd($formDetails->form_detail);
        return view('backend.form.' . $string, compact('formDetails', 'form_name'));
    }

    public function getFormBuilder($form_name)
    {
        $company_id = auth()->user()->company_id;
        $formDetails = FormDetail::where('company_id',$company_id)->where('form_name',$form_name)->first();
        // dd($formDetails->form_detail);
        $form_detail = json_decode($formDetails->form_detail,true);
        $form_detail = json_encode($form_detail['result']);
        // dd($form_detail);
        return view('backend.form.builder.index',compact('formDetails','form_detail'));
    }

    public function storeFormApplication(Request $request, $form_name)
    {
        dd($request->all());
        DB::transaction(function () use ($request, $form_name) {
            // dd($request->all(), $form_name);
            Mail::to($request->ReportingTo)
            ->cc($request->EmailTrigger)
            ->send(new LeaveRequestMail($request->all(),$form_name));
        });
        // return view('backend.form.mail.leave-request',['requestData'=>$request->all(),'formName'=>$form_name]);
        return redirect()->back()->with('success','Your request sent Successfully.');
    }
}
