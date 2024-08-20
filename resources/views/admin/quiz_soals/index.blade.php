@extends('layouts.app')

@section('title', 'Daftar Soal untuk {{ $mapel->name }}')

@section('content')
    <div class="container">
        <h1>Daftar Soal untuk {{ $mapel->name }}</h1>
        <a href="{{ route('quiz_soals.create', ['mapel_id' => $mapel->id]) }}" class="btn btn-primary">Tambah Soal</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Soal</th>
                    <th>Opsi A</th>
                    <th>Opsi B</th>
                    <th>Opsi C</th>
                    <th>Opsi D</th>
                    <th>Kunci</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($soals as $soal)
                    <tr>
                        <td>{{ $soal->id }}</td>
                        <td>{{ $soal->question }}</td>
                        <td>{{ $soal->option_a }}</td>
                        <td>{{ $soal->option_b }}</td>
                        <td>{{ $soal->option_c }}</td>
                        <td>{{ $soal->option_d }}</td>
                        <td>{{ $soal->key }}</td>
                        <td>
                            <a href="{{ route('quiz_soals.edit', $soal->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('quiz_soals.destroy', $soal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
