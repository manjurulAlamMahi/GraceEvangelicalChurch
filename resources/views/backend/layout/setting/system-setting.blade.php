@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper{
            height: inherit !important;
        }
        .banner_dropify .dropify-wrapper{
            height: 160px !important;
        }
    </style>
@endpush
@section('title', 'System Setting')
@section('content')
    <div class="app-content content ">
        <!-- General setting Form section start -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">System Setting</h3>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('system.settingupdate') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="country">Logo</label>
                                <input class="form-control dropify" type="file" name="logo"
                                    @isset($setting->logo)
                                                   data-default-file="{{ asset($setting->logo) }}"
                                    @endisset>
                                @error('logo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="country">Favicon</label>
                                <input class="form-control dropify" type="file" name="favicon"
                                    @isset($setting->favicon)
                                                data-default-file="{{ asset($setting->favicon) }}"
                                    @endisset>
                                @error('favicon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group banner_dropify">
                                <label for="country">Banner Image</label>
                                <input class="form-control dropify" type="file" name="banner_image"
                                    @isset($setting->banner_image)
                                                data-default-file="{{ asset($setting->banner_image) }}"
                                    @endisset>
                                @error('banner_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Website Url <span class="text-danger">*</span></label>
                                        <input type="text" id="url" class="form-control"
                                            value="{{ $setting->url ?? '' }}" placeholder="Site Url" name="url" />
                                        @error('url')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Website Title <span class="text-danger">*</span></label>
                                        <input type="text" id="system_title" class="form-control"
                                            value="{{ $setting->system_title ?? '' }}" placeholder="System title" name="system_title" />
                                        @error('system_title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Website Short Title</label>
                                        <input type="text" id="title" class="form-control"
                                            value="{{ $setting->system_short_title ?? '' }}" placeholder="System title" name="system_short_title" />
                                        @error('system_short_title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="first-name-column">Banner Title <span class="text-danger">*</span></label>
                                        <textarea name="banner_title" class="form-control" placeholder="Banner Title" id="" cols="30" rows="5">{{ $setting->banner_title }}</textarea>
                                        @error('banner_title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="first-name-column">Banner Description <span class="text-danger">*</span></label>
                                        <textarea name="banner_description" class="form-control" placeholder="Banner Description" id="" cols="30" rows="5">{{ $setting->banner_description }}</textarea>
                                        @error('banner_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Contact Description <span class="text-danger">*</span></label>
                                        <textarea name="contact_description" class="form-control" placeholder="Contact Description" id="" cols="30" rows="3">{{ $setting->contact_description }}</textarea>
                                        @error('contact_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="country">Copyright text</label>
                                        <input type="text" class="form-control" name="copyright_text" id="copyright_text"
                                            value="{{ $setting->copyright_text ?? '' }}" placeholder="Copyright Text">
                                        @error('copyright_text')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary mr-1">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

        <script>
            $('.dropify').dropify();
        </script>
    @endpush
@endsection
