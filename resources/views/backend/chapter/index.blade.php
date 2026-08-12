@extends('backend.app')

@section('title', 'Chapter Page')

@push('style')
    <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <style>
        .dropify-wrapper {
            width: 160px;
        }

        #data-table th,
        #data-table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush
@section('content')
    <main class="app-content content">
        <div class="row">
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0"><span class="btn-text">Add</span> Chapter</h4>
                    </div>
                    <div class="card-body">
                        <form id="addChapter" action="{{ route('chapter.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id') }}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Select Book <span
                                                class="text-danger">*</span></label>
                                        <select name="book_id" class="form-control" id="">
                                            <option value="">-- Select Book --</option>
                                            @foreach ($books as $book)
                                                <option
                                                    {{ isset($_GET['book_id']) && $_GET['book_id'] == $book->id ? 'selected' : '' }}
                                                    value="{{ $book->id }}">{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Total Chapters</label>
                                        <input type="text" class="form-control" id="totalChapter" readonly
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Chapter No. <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="no"
                                            value="{{ old('no') }}">
                                        <span class="text-danger noExists" style="display: none;">Chapter No. already
                                            exists</span>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Chapter Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Chapter Duration <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="duration"
                                            value="{{ old('duration') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date"
                                            value="{{ old('date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Audio <span
                                                class="text-danger">*</span></label>
                                        <input type="file" id="audioInput" class="form-control" name="audio">
                                    </div>
                                </div>
                                <div class="col-lg-4 align-self-center" id="audioPreviewDiv" style="display: none;">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Audio Preview</label><br>
                                        <audio id="audioPreview" controls></audio>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" onclick="cancelAddItem()" class="btn btn-sm btn-danger cancel-add-item" style="display: none;">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ri-add-line"></i>
                                    <span class="btn-text">Add</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">Chapter List</h4>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Chapter No.</th>
                                    <th>Chapter Date</th>
                                    <th>Chapter Title</th>
                                    <th>Duration</th>
                                    <th>Audio</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/datatable/js/datatables.min.js') }}"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        document.getElementById('audioInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const audioURL = URL.createObjectURL(file);
                const audio = document.getElementById('audioPreview');
                const audioDiv = document.getElementById('audioPreviewDiv');
                audio.src = audioURL;
                audioDiv.style.display = 'block';
            }
        });
    </script>

    <script>
        let table;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

            // Initialize once
            table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('chapter.index') }}",
                    data: function(d) {
                        d.book_id = $('select[name="book_id"]').val();
                    }
                },
                columns: [{
                        data: 'book.title',
                        name: 'book.title',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'no',
                        name: 'no',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'audio',
                        name: 'audio',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Just update the count when data is loaded
            table.on('xhr', function(e, settings, json) {
                $('#totalChapter').val(json.totalChapter); // make sure it's `.text()` not `.val()`
            });

            // Reload data on select change
            $('select[name="book_id"]').on('change', function() {
                table.ajax.reload();
                let id = $('input[name="id"]').val();
                let no = $('input[name="no"]').val();
                if(id != '' && no != '') {
                    checkchapterno(id, no);
                }
            });
        });

        function editChapter(id) {
            $.ajax({
                url: "{{ route('chapter.get') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response) {
                        let imgPath = "{{ asset('') }}" + response[0].audio;
                        $('#audioPreview').attr('src', imgPath);

                        $('input[name="id"]').val(response[0].id);
                        $('select[name="book_id"]').val(response[0].book_id);
                        $('input[name="no"]').val(response[0].no);
                        $('input[name="title"]').val(response[0].title);
                        $('input[name="duration"]').val(response[0].duration);
                        $('input[name="date"]').val(response[0].date);
                        $('#audioPreviewDiv').show();
                        $('#audioInput').attr('disabled', true).attr('required', false);
                        $('#addChapter').attr('action', "{{ route('chapter.update') }}");
                        $('.btn-text').text('Update');
                        $('.cancel-add-item').show();

                        table.ajax.reload();

                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function cancelAddItem() {
            $('#addChapter')[0].reset();
            $('#audioPreviewDiv').hide();
            $('#audioInput').attr('disabled', false).attr('required', true);
            $('#addChapter').attr('action', "{{ route('chapter.store') }}");
            $('.btn-text').text('Add');
            $('.cancel-add-item').hide();
            $('input[name="id"]').val('');
            $('input[name="no"]').val('');
            $('input[name="title"]').val('');
            $('input[name="duration"]').val('');
            $('input[name="date"]').val('');
            $('#audioPreview').attr('src', '');
            $('#totalChapter').val('');
            $('.noExists').hide();
            table.ajax.reload();
        }
    </script>

    <script>
        $('input[name="no"]').on('keyup', function() {
            let input = $(this).val();
            let id = $('input[name="id"]').val();
            checkchapterno(id, input);
        });

        function checkchapterno(id, no) {
            $.ajax({
                url: "{{ route('chapter.get') }}",
                type: "GET",
                data: {
                    id: id,
                    book_id: $('select[name="book_id"]').val(),
                    no: no,
                },
                success: function(response) {
                    if (response.length > 0) {
                        $('.noExists').show();
                    } else {
                        $('.noExists').hide();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endpush
