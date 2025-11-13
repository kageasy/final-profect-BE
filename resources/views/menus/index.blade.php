@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Menu</h2>
        <a href="{{ route('menus.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus-circle"></i> Tambah Menu Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('menus.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Pencarian</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama menu...">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="">Semua Kategori</option>
                            <option value="Makanan" {{ request('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ request('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack" {{ request('kategori') == 'Snack' ? 'selected' : '' }}>Snack</option>
                            <option value="Dessert" {{ request('kategori') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="sort" class="form-label">Urutkan</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(request('search') || request('kategori'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            Menampilkan hasil untuk:
            @if(request('search'))
                <strong>Pencarian: "{{ request('search') }}"</strong>
            @endif
            @if(request('kategori'))
                <strong>Kategori: {{ request('kategori') }}</strong>
            @endif
            <span class="ms-2">({{ $menus->total() }} menu ditemukan)</span>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            @php
                                $kategori = strtolower($menu->kategori);
                                $badgeClass = match($kategori) {
                                    'makanan' => 'bg-danger',
                                    'minuman' => 'bg-info text-dark',
                                    'snack' => 'bg-warning text-dark',
                                    'dessert' => 'bg-success',
                                    default => 'bg-secondary'
                                };

                                $icon = match($kategori) {
                                    'makanan' => 'fa-solid fa-utensils',
                                    'minuman' => 'fa-solid fa-mug-saucer',
                                    'snack'   => 'fa-solid fa-cookie-bite',
                                    'dessert' => 'fa-solid fa-ice-cream',
                                    default   => 'fa-solid fa-circle-question'
                                };

                            @endphp
                            <tr>
                                <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $menu->nama }}</strong></td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        <i class="fa {{ $icon }}"></i> {{ $menu->kategori }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>{{ Str::limit($menu->deskripsi, 50) }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('menus.show', $menu->id) }}"
                                           class="btn btn-icon-square btn-view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('menus.edit', $menu->id) }}"
                                           class="btn btn-icon-square btn-edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon-square btn-delete" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fs-1 d-block mb-2"></i>
                                        @if(request('search') || request('kategori'))
                                            <p class="mb-0">Tidak ada menu yang sesuai dengan pencarian</p>
                                        @else
                                            <p class="mb-0">Belum ada data menu</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($menus, 'links'))
        <div class="mt-4 d-flex justify-content-center">
            {{ $menus->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.05);
        transition: background-color 0.2s ease;
    }

    .badge i {
        margin-right: 3px;
    }

    .btn-icon-square {
        width: 40px;
        height: 40px;
        padding: 0;
        border: none;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.2s ease;
    }

    .btn-view {
        background-color: #0dcaf0;
        color: white;
    }

    .btn-view:hover {
        background-color: #0ba5d4;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.4);
    }

    .btn-edit {
        background-color: #ffc107;
        color: white;
    }

    .btn-edit:hover {
        background-color: #e0a800;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #bb2d3b;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    .btn-icon-square:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.25);
    }
</style>
@endsection