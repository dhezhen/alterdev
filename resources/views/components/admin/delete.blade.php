@props(['action', 'confirm' => 'Hapus data ini? Tindakan ini tidak dapat dibatalkan.', 'label' => null])
<form method="POST" action="{{ $action }}" class="inline" data-confirm="{{ $confirm }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" @if (! $label) aria-label="Hapus" title="Hapus" @endif>
        <x-icon name="trash" size="15" stroke="2" />{{ $label }}
    </button>
</form>
