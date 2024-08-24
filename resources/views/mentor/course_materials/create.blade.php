@section('title-page')
    Dashboard Mentor
@endsection

@section('css')
    <style>
        .card-step {
            min-height: 350px;
        }

        .card-step .deskripsi-step {
            height: 90px;
        }

        .ck-editor__editable {
            min-height: 200px; /* Set your desired height */
        }
    </style>
@endsection

@extends('mentor/template/index')
@section('content')
    <div class="container-fluid">
        <div class="row">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h1>{{ isset($material) ? 'Edit' : 'Add' }} Material</h1>

            <form
                action="{{ isset($material) ? route('materials.update', [$course->id, $material->id]) : route('materials.store', $course->id) }}"
                method="POST">
                @csrf
                @if (isset($material))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ isset($material) ? $material->title : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" class="form-control" id="editor" rows="4">{{ isset($material) ? $material->content : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ isset($material) && $material->status == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ isset($material) && $material->status == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">{{ isset($material) ? 'Update' : 'Add' }}</button>
            </form>

        </div>

    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });
    </script>
    
@endsection
