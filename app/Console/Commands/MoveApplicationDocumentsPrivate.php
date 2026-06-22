<?php

namespace App\Console\Commands;

use App\Models\ApplicationDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MoveApplicationDocumentsPrivate extends Command
{
    protected $signature = 'app:move-application-documents-private
        {--commit : Move files instead of running a dry run}
        {--delete-public : Delete the public copy after a verified private copy exists}
        {--force : Skip confirmation prompts}
        {--limit= : Limit the number of documents to scan}';

    protected $description = 'Move existing public application documents into private local storage.';

    public function handle(): int
    {
        $commit = (bool) $this->option('commit');
        $deletePublic = (bool) $this->option('delete-public');
        $limit = $this->limit();

        if ($deletePublic && ! $commit) {
            $this->warn('The --delete-public option is ignored during a dry run.');
            $deletePublic = false;
        }

        if ($deletePublic && ! $this->option('force')) {
            $confirmed = $this->confirm(
                'This will delete public copies after private copies are verified. Continue?',
                false
            );

            if (! $confirmed) {
                $this->warn('Cancelled.');

                return self::FAILURE;
            }
        }

        $this->components->info($commit
            ? 'Moving application documents into private storage...'
            : 'Dry run: scanning public application documents...');

        $stats = [
            'scanned' => 0,
            'would_move' => 0,
            'moved' => 0,
            'already_private' => 0,
            'public_deleted' => 0,
            'missing_public' => 0,
            'blank_path' => 0,
            'failed' => 0,
        ];

        $query = ApplicationDocument::query()
            ->select(['id', 'file_path'])
            ->orderBy('id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        foreach ($query->cursor() as $document) {
            $stats['scanned']++;

            $this->moveDocument($document, $commit, $deletePublic, $stats);
        }

        $this->table(
            ['Metric', 'Count'],
            collect($stats)
                ->map(fn (int $count, string $metric): array => [str_replace('_', ' ', $metric), $count])
                ->values()
                ->all()
        );

        if (! $commit) {
            $this->line('Run with --commit to copy missing private files.');
        }

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @param  array<string, int>  $stats
     */
    private function moveDocument(ApplicationDocument $document, bool $commit, bool $deletePublic, array &$stats): void
    {
        $path = trim((string) $document->file_path);

        if ($path === '') {
            $stats['blank_path']++;

            return;
        }

        $localDisk = Storage::disk('local');
        $publicDisk = Storage::disk('public');

        $isPrivate = $localDisk->exists($path);
        $isPublic = $publicDisk->exists($path);

        if ($isPrivate) {
            $stats['already_private']++;

            if ($commit && $deletePublic && $isPublic) {
                if (! $this->privateCopyMatchesPublic($path)) {
                    $stats['failed']++;
                    $this->error("Existing private copy verification failed for document {$document->id}: {$path}");

                    return;
                }

                $publicDisk->delete($path);
                $stats['public_deleted']++;
            }

            return;
        }

        if (! $isPublic) {
            $stats['missing_public']++;
            $this->warn("Missing public file for document {$document->id}: {$path}");

            return;
        }

        if (! $commit) {
            $stats['would_move']++;

            return;
        }

        try {
            $publicContents = $publicDisk->get($path);

            $localDisk->put($path, $publicContents);

            if (! $this->privateCopyMatchesPublic($path)) {
                $stats['failed']++;
                $this->error("Private copy verification failed for document {$document->id}: {$path}");

                return;
            }

            $stats['moved']++;

            if ($deletePublic) {
                $publicDisk->delete($path);
                $stats['public_deleted']++;
            }
        } catch (Throwable $throwable) {
            $stats['failed']++;
            $this->error("Failed to move document {$document->id}: {$throwable->getMessage()}");
        }
    }

    private function privateCopyMatchesPublic(string $path): bool
    {
        $localDisk = Storage::disk('local');
        $publicDisk = Storage::disk('public');

        return $localDisk->exists($path)
            && $localDisk->size($path) === $publicDisk->size($path);
    }

    private function limit(): ?int
    {
        $limit = $this->option('limit');

        if ($limit === null || $limit === '') {
            return null;
        }

        if (! is_numeric($limit) || (int) $limit < 1) {
            $this->fail('The --limit option must be a positive integer.');
        }

        return (int) $limit;
    }
}
