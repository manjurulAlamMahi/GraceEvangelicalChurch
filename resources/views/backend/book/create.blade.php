@extends('backend.app')

@section('title', 'Create Book')

@push('style')
@endpush

@section('content')
    <main class="app-content content">
        <form action="{{ route('book.store') }}" method="POST">@csrf
            <div class="card card-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="card-header p-0 m-0">
                            <h4 class="m-0">Create Book</h4>
                            <a href="{{ route('book.index') }}" class="btn btn-primary"><i class="ri-list-check"></i> Book List</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" class="form-control" id="">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $cate)
                                <option value="{{$cate->id}}">{{$cate->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
@endsection

@push('script')
@include('backend.partials.ckeditor')
@endpush
