@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="container">
    <h2>Ajukan Peminjaman</h2>

    @if(isset($selectedBarangId))
        @php
            $selectedBarang = $barangs->firstWhere('id', $selectedBarangId);
        @endphp
        <div class="alert alert-info">
            Barang yang dipilih: <strong>{{ $selectedBarang->nama ?? '-' }}</strong>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="barang_id" class="form-label">Pilih Barang</label>
            <select name="barang_id" class="form-control" required>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ (isset($selectedBarangId) && $selectedBarangId == $barang->id) ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="foto-input" class="form-label">Foto Bukti/Surat</label>
            <input type="file" id="foto-input" accept="image/*" class="form-control">
            <input type="hidden" name="foto" id="foto">
        </div>
        <div class="preview-wrapper mt-3" id="preview-wrapper">
            <img id="cropper-image" style="max-width: 100%; display: none;" />
        </div>
        <button type="button" onclick="cropImage()" class="btn btn-warning mt-2">📸 Crop & Gunakan</button>
        <button type="submit" class="btn btn-success mt-2">Ajukan</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const input = document.getElementById('foto-input');
    const image = document.getElementById('cropper-image');
    const hiddenInput = document.getElementById('foto');

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                image.src = event.target.result;
                image.style.display = 'block';

                if (cropper) cropper.destroy();
                cropper = new Cropper(image, {
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    function cropImage() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 600
            });
            const base64 = canvas.toDataURL('image/jpeg');
            hiddenInput.value = base64;
            alert('Gambar sudah dicrop dan siap disimpan!');
        }
    }
</script>

<style>
    .preview-wrapper {
        width: 100%;
        max-width: 400px;
        aspect-ratio: 4 / 3;
        border: 1px solid #ccc;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .preview-wrapper img {
        max-width: 100%;
        max-height: 100%;
    }
</style>
@endsection