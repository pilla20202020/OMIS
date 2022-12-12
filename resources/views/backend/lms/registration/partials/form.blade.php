@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head mt-2 p-3">
                    <header>{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Campaign</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name"
                                        value="{{ old('name', isset($campaign->name) ? $campaign->name : '') }}"
                                        placeholder="Enter Your Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4" id="imageupload">
                            <label class="text-default-light">Banner Image</label>
                            @if (isset($campaign) && $campaign->banner)
                                <input type="file" name="banner" class="dropify"
                                    data-default-file="{{ asset($campaign->banner_path) }}" />
                            @else
                                <input type="file" name="banner" class="dropify" />
                            @endif
                        </div>
                        <div class="col-md-4" id="imageupload2">

                            <label class="text-default-light">OG Image</label>
                            @if (isset($campaign) && $campaign->ogImage)
                                <input type="file" name="ogImage" class="dropify"
                                    data-default-file="{{ asset($campaign->ogImage_thumbnail_path) }}" />
                            @else
                                <input type="file" name="ogImage" class="dropify" />
                            @endif
                        </div>

                    </div>

                    <div class="row mt-2">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea name="details" class="form-control">{{ old('details', isset($campaign->details) ? $campaign->details : '') }}
                                </textarea>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('details') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Name">Success Message, Please use '< name >' to display name in success message</label>
                                <textarea name="success_message" class="form-control" rows="4">{{ old('success_message', isset($campaign->success_message) ? $campaign->success_message : '') }}
                                </textarea>


                                <span id="textarea1-error"
                                    class="text-danger">{{ $errors->first('success_message') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Name">SMS Message, Please use '< name >' to display name in sms message</label>
                                <textarea name="sms_message" class="form-control" rows="4">{{ old('sms_message', isset($campaign->sms_message) ? $campaign->sms_message : '') }}
                                </textarea>


                                <span id="textarea1-error"
                                    class="text-danger">{{ $errors->first('sms_message') }}</span>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="Name">Email Success Message.Please use '< name >' to display name in email.</label>
                            <span id="textarea1-error" class="text-danger">{{ $errors->first('email_success') }}</span>
                            <div class="form-group">
                                <textarea name="email_success" class="form-control" rows="4">{{ old('email_success', isset($campaign->email_success) ? $campaign->email_success : '') }}
                                </textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="to">Offerd Course, Use (enter) for multiple</label>
                            <select name="offered_course[]" class="form-control offerd_course" id="to" multiple>
                                @if(isset($campaign_course) )
                                    @foreach ($campaign_course as $course)
                                        <option value="{{$course}}" selected>{{$course}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger">{{ $errors->has('offered_course') ? $errors->first('offered_course') : '' }} </span>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="starts">Starts</label>
                                <input type="date" name="starts" class="form-control" required
                                    value="{{ old('starts', isset($campaign->starts) ? $campaign->starts : '') }}" />

                                <span id="textarea1-error" class="text-danger">{{ $errors->first('starts') }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ends">Ends</label>
                                <input type="date" name="ends" class="form-control" required
                                    value="{{ old('ends', isset($campaign->ends) ? $campaign->ends : '') }}" />

                                <span id="textarea1-error" class="text-danger">{{ $errors->first('ends') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <strong>Description</strong>
                                <textarea name="description" id="" class="ckeditor">{{ old('description', isset($campaign->description) ? $campaign->description : '') }}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Coupen Codes</strong>
                                <textarea name="coupon_codes" id="coupon_codes" class="form-control" rows="4">{{ old('coupon_codes', isset($campaign->coupon_codes) ? $campaign->coupon_codes : '') }}</textarea>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <strong>OG Tags</strong>
                                <textarea name="ogtags" id="ogtags" class="form-control" rows="4">{{ old('ogtags', isset($campaign->ogtags) ? $campaign->ogtags : '') }}</textarea>

                            </div>
                        </div>




                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <strong>Headers</strong>
                                <textarea name="headers" class="form-control" rows="4">{{ old('headers', isset($campaign->headers) ? $campaign->headers : '') }}</textarea>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="Name">Keywords - Use (enter) for multiple</label>
                            <select name="keywords[]" class="form-control offerd_course" multiple>
                                @if(isset($keywords) )
                                    @foreach ($keywords as $keyword)
                                        <option value="{{$keyword}}" selected>{{$keyword}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger">{{ $errors->has('keywords') ? $errors->first('keywords') : '' }} </span>
                        </div>


                    </div>




                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group d-flex">
                            <span class="pl-1">Status</span>
                            <input type="checkbox" id="switch1" switch="none" name="status"
                                {{ old('status', isset($campaign->status) ? $campaign->status : '') == 'active' ? 'checked' : '' }} />
                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('lms.campaign.index') }}">
                                <i class="md md-arrow-back"></i>
                                Back
                            </a>
                            <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light"
                                value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('js')

    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
        $(function () {
            $('.ckeditor').each(function (e) {
            });
        });

        $('.offerd_course').select2({
            tags: true
        });
    </script>
@endsection
