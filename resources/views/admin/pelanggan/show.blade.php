@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail Pelanggan</h1>
        </div>
        <div>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-gray-600"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    {{-- CARD 1: INFORMASI PELANGGAN --}}
    <div class="col-12 col-xl-6">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">Informasi Umum</h2>
            <form>
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $pelanggan->first_name }} {{ $pelanggan->last_name }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $pelanggan->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" class="form-control" value="{{ $pelanggan->phone }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="text" class="form-control" value="{{ $pelanggan->birthday }}" readonly>
                </div>
            </form>
        </div>
    </div>

    {{-- CARD 2: FILE PENDUKUNG (UPLOAD MULTIPLE) --}}
    <div class="col-12 col-xl-6">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">File Pendukung</h2>

            {{-- Form Upload --}}
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- INPUT HIDDEN (PENTING SESUAI SOAL) --}}
                <input type="hidden" name="ref_table" value="pelanggan">
                <input type="hidden" name="ref_id" value="{{ $pelanggan->pelanggan_id }}">

                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Upload File (Bisa pilih banyak)</label>
                    <input class="form-control" type="file" id="formFileMultiple" name="files[]" multiple required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-100">Upload File</button>
            </form>
            
            <hr>

            {{-- List File yang Sudah Diupload --}}
            <h6 class="mt-4">List File:</h6>
            @if($files->isEmpty())
                <p class="text-muted small">Belum ada file pendukung.</p>
            @else
                <ul class="list-group">
                    @foreach($files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                {{-- Icon Sederhana Berdasarkan Ekstensi --}}
                                @php $ext = pathinfo($file->filename, PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('uploads/'.$file->filename) }}" width="40" class="me-3 rounded">
                                @else
                                    <i class="fas fa-file me-3 fa-2x text-secondary"></i>
                                @endif
                                
                                <a href="{{ asset('uploads/'.$file->filename) }}" target="_blank" class="text-decoration-none text-dark">
                                    {{ Str::limit($file->filename, 20) }}
                                </a>
                            </div>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('upload.destroy', $file->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Hapus file ini?')">
                                    <span class="fas fa-trash-alt"></span>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection