@extends('backend.app')

@section('title', 'AboutUs Page')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper {
            height: 250px !important;
        }
    </style>
@endpush

@section('content')
    <main class="app-content content">
        <form action="{{ route('aboutus.update') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-body">
                        <h5 class="section-title bg-secondary p-2 text-white mb-3">AboutUs Page</h5>
                        <div class="mb-3">
                            <label for="" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $aboutus->title) }}">
                        </div>
                        <div class="mb-3">
                            <label for="country">Image <span class="text-danger">(735 x 790)</span></label>
                            <input class="form-control dropify" type="file" name="image" data-default-file="{{ asset($aboutus->image) }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card card-body">
                        <h5 class="section-title bg-secondary p-2 text-white mb-3">AboutUs Page Description</h5>
                        <div class="mb-3">
                            <textarea name="description" class="ck-editor">{!! old('description', $aboutus->description) !!}</textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
@endsection

@push('script')
    @include('backend.partials.ckeditor')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify();
    </script>
@endpush
