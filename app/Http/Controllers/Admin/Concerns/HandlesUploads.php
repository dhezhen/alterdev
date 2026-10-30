<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    /**
     * Simpan file unggahan ke disk "public" dan hapus file lama.
     * Mengembalikan path baru, path lama (bila tidak ada unggahan), atau null bila diminta hapus.
     */
    protected function storeUpload(Request $request, string $field, string $folder, ?string $oldPath = null): ?string
    {
        if ($request->boolean('remove_'.$field)) {
            $this->deleteFile($oldPath);

            return null;
        }

        if ($request->hasFile($field)) {
            $this->deleteFile($oldPath);

            return $request->file($field)->store($folder, 'public');
        }

        return $oldPath;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /** Ubah teks multi-baris menjadi array (satu baris satu item). */
    protected function linesToArray(?string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $text))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /** Ubah teks dipisah koma menjadi array. */
    protected function commaToArray(?string $text): array
    {
        return collect(explode(',', (string) $text))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
