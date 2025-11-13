@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Detail Menu</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Menu:</div>
                        <div class="col-md-8">{{ $menu->nama }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kategori:</div>
                        <div class="col-md-8">
                            <span class="badge bg-info">{{ $menu->kategori }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Harga:</div>
                        <div class="col-md-8">
                            <span class="text-success fw-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Deskripsi:</div>
                        <div class="col-md-8">
                            @if($menu->deskripsi)
                                <p class="mb-0">{{ $menu->deskripsi }}</p>
                            @else
                                <span class="text-muted">Tidak ada deskripsi</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Dibuat pada:</div>
                        <div class="col-md-8">{{ $menu->created_at->format('d F Y, H:i') }} WIB</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Terakhir diupdate:</div>
                        <div class="col-md-8">{{ $menu->updated_at->format('d F Y, H:i') }} WIB</div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('menus.destroy', $menu->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection