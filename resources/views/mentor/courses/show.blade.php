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
    </style>
@endsection

@extends('mentor/template/index')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('materials.create', $course->id) }}" class="btn btn-primary">Add Material</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h1>{{ $course->title }}</h1>
            <p>{{ $course->description }}</p>

            <h2>Materials</h2>
            @if ($course->courseMaterials)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->courseMaterials as $material)
                            <tr>
                                <td>{{ $material->title }}</td>
                                <td>{{ $material->status ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <a href="{{ route('materials.edit', [$course->id, $material->id]) }}"
                                        class="btn btn-warning">Edit</a>
                                    <a href="#" class="btn btn-danger"
                                        onclick="confirmDeleteMaterial({{ $material->id }})">
                                        Delete
                                    </a>
                                    <form id="delete-form-{{ $material->id }}"
                                        action="{{ route('materials.destroy', [$course->id, $material->id]) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    {{-- <form action="{{ route('materials.destroy', [$course->id, $material->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });

        function confirmDeleteMaterial(id) {
            Swal.fire({
                title: 'Apa Yakin Menghapus Materi?',
                text: "Anda Tidak bisa mengulangi lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
