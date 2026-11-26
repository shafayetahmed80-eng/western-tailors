<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private const FAVICON_PATH = 'general/western-favicon.png';

    private const FAVICON_MIME = 'image/png';

    public function up(): void
    {
        if (Schema::hasTable('media_files')) {
            $folderId = 0;

            if (Schema::hasTable('media_folders')) {
                $generalFolder = DB::table('media_folders')
                    ->where('slug', 'general')
                    ->whereNull('deleted_at')
                    ->first();

                if ($generalFolder) {
                    $folderId = (int) $generalFolder->id;
                }
            }

            $filePath = public_path('storage/' . self::FAVICON_PATH);
            $fileSize = file_exists($filePath) ? (int) filesize($filePath) : 0;
            $now = now();

            $mediaPayload = [
                'user_id' => 0,
                'name' => 'western-favicon',
                'folder_id' => $folderId,
                'mime_type' => self::FAVICON_MIME,
                'size' => $fileSize,
                'options' => '[]',
                'updated_at' => $now,
            ];

            if (Schema::hasColumn('media_files', 'alt')) {
                $mediaPayload['alt'] = 'Western Bespoke Favicon';
            }

            if (Schema::hasColumn('media_files', 'visibility')) {
                $mediaPayload['visibility'] = 'public';
            }

            if (Schema::hasColumn('media_files', 'deleted_at')) {
                $mediaPayload['deleted_at'] = null;
            }

            $existing = DB::table('media_files')
                ->where('url', self::FAVICON_PATH)
                ->first();

            if ($existing) {
                DB::table('media_files')
                    ->where('id', $existing->id)
                    ->update($mediaPayload);
            } else {
                $mediaPayload['url'] = self::FAVICON_PATH;
                $mediaPayload['created_at'] = $now;
                DB::table('media_files')->insert($mediaPayload);
            }
        }

        if (Schema::hasTable('settings')) {
            $faviconSettings = [
                'theme-ninico-favicon' => self::FAVICON_PATH,
                'theme-ninico-favicon_type' => self::FAVICON_MIME,
                'admin_favicon' => self::FAVICON_PATH,
                'admin_favicon_type' => self::FAVICON_MIME,
            ];

            $now = now();

            foreach ($faviconSettings as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => $now]
                );
            }

            cache()->forget('core.base.boot_settings');
        }

        Log::info('Updated Western Bespoke brand favicon and favicon MIME type settings.');
    }

    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            $now = now();

            foreach ([
                'theme-ninico-favicon' => 'general/favicon.png',
                'theme-ninico-favicon_type' => 'image/x-icon',
                'admin_favicon' => 'western-logo-transparent.png',
                'admin_favicon_type' => 'image/x-icon',
            ] as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => $now]
                );
            }

            cache()->forget('core.base.boot_settings');
        }

        if (Schema::hasTable('media_files')) {
            DB::table('media_files')
                ->where('url', self::FAVICON_PATH)
                ->delete();
        }
    }
};
