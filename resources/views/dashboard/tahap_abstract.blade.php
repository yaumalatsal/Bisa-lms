@section('title-page')
    Abstrak Produk
@endsection

@section('css')
    <style>
.member-area{
            padding:10px;
            background-color:#ededed; 
        }

        h4 small{
            font-size:12px;
        }

        .swal2-popup {
            font-size: 1.6rem !important;
        }

        @media only screen and (max-width:720px){
            .modal-dialog{
                max-width:100%;
            }         
        }
</style>
@endsection

@extends('dashboard_template/index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-2">
                        <h3>Buat Produk Hebatmu!</h3>                
                        <small>
                            Dalam pembangunan StartUp, produk akan menjadi senjata fundamental agar dapat bersaing dan berkembang.
                            Buatlah produk terbaikmu, yang kreatif, inovatif, dan berimpact besar.
                        </small>
                        <br><br>
                        @if (session('status'))
                            <div style="width:100%" class="alert alert-primary" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{-- The field captions were <h4> headings, so nothing was
                             actually labelled: clicking a caption did not focus its
                             field and assistive tech announced them as unnamed. --}}
                        <form id="productForm" action="{{ url('/register_produk') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label class="form-label h5 d-block" for="nama_produk">
                                    <span class="fas fa-archive" aria-hidden="true"></span> Nama Produk
                                </label>
                                <p class="text-muted mb-2">Nama produk bisa berasal dari singkatan atau istilah
                                    yang berhubungan dengan produkmu.</p>
                                <input type="text" id="nama_produk" name="nama_produk" class="form-control"
                                    value="{{ old('nama_produk') }}" required maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="form-label h5 d-block" for="deskripsi">
                                    <span class="fas fa-align-left" aria-hidden="true"></span> Deskripsi Singkat Produk
                                </label>
                                <p class="text-muted mb-2">Deskripsikan produkmu secara singkat: bidang yang
                                    dinaungi, sasaran pasar, bentuk produk, alur singkat penggunaan produk, dan hal
                                    lain yang menggambarkan produkmu.</p>
                                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="10"
                                    required>{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label h5 d-block" for="mentor">
                                    <span class="fas fa-user" aria-hidden="true"></span> Mentor
                                </label>
                                <p class="text-muted mb-2">Mentor yang dipilih adalah wirausaha berpengalaman yang
                                    akan mendampingi pengembangan produkmu.</p>
                                <select id="mentor" name="mentor" class="form-control" required>
                                    @foreach ($getmentor as $data)
                                        <option value="{{ $data->id }}" @selected(old('mentor') == $data->id)>
                                            {{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary float-end" type="submit">
                                Selanjutnya <span class="fas fa-chevron-right" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>             
                </div>
            </div>            
        </div>    
    </div>
</div>
@endsection

@section('js')
<script>
    $(function(){
        // SweetAlert sebelum submit form
        $('#productForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah submit form langsung

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan semua data yang diisi sudah benar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit form jika dikonfirmasi
                }
            });
        });

    });
</script>
@endsection
