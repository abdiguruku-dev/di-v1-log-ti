@props(['show' => null, 'edit' => null, 'delete' => null, 'name' => 'Data ini'])

<div class="d-flex justify-content-center gap-2 align-items-center" style="white-space: nowrap;">
    
    {{-- 1. TOMBOL LIHAT (Jika route 'show' diisi) --}}
    @if($show)
    <a href="{{ $show }}" 
       class="text-info me-1" 
       style="font-size: 1.2rem; text-decoration: none; cursor: pointer;" 
       title="Lihat Detail">
        <i class="bi bi-eye"></i>
    </a>
    @endif

    {{-- 2. TOMBOL EDIT (Jika route 'edit' diisi) --}}
    @if($edit)
    <a href="{{ $edit }}" 
       class="text-warning me-1" 
       style="font-size: 1.2rem; text-decoration: none; cursor: pointer;" 
       title="Edit Data">
        <i class="bi bi-pencil-square"></i>
    </a>
    @endif

    {{-- 3. TOMBOL HAPUS (Jika route 'delete' diisi) --}}
    @if($delete)
    <form action="{{ $delete }}" 
          method="POST" 
          class="d-inline form-delete" 
          data-name="{{ $name }}">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="text-danger border-0 bg-transparent p-0" 
                style="font-size: 1.2rem; cursor: pointer;" 
                title="Hapus Data">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endif
    
</div>