<?php

namespace App\Console\Commands;

use App\Models\ApplicationDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class EncryptApplicationDocumentNumbers extends Command
{
    protected $signature = 'app:encrypt-application-document-numbers
        {--commit : Encrypt plaintext values instead of running a dry run}
        {--limit= : Limit the number of documents to scan}';

    protected $description = 'Encrypt existing plaintext NIN and BVN document numbers.';

    public function handle(): int
    {
        $commit = (bool) $this->option('commit');
        $limit = $this->limit();

        $this->components->info($commit
            ? 'Encrypting plaintext application document numbers...'
            : 'Dry run: scanning plaintext application document numbers...');

        $stats = [
            'scanned' => 0,
            'blank' => 0,
            'already_encrypted' => 0,
            'would_encrypt' => 0,
            'encrypted' => 0,
            'failed' => 0,
        ];

        $query = ApplicationDocument::query()
            ->select(['id', 'document_number'])
            ->whereNotNull('document_number')
            ->orderBy('id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        foreach ($query->cursor() as $document) {
            $stats['scanned']++;

            $this->encryptDocumentNumber($document, $commit, $stats);
        }

        $this->table(
            ['Metric', 'Count'],
            collect($stats)
                ->map(fn (int $count, string $metric): array => [str_replace('_', ' ', $metric), $count])
                ->values()
                ->all()
        );

        if (! $commit) {
            $this->line('Run with --commit to encrypt plaintext values.');
        }

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @param  array<string, int>  $stats
     */
    private function encryptDocumentNumber(ApplicationDocument $document, bool $commit, array &$stats): void
    {
        $rawNumber = $document->getRawOriginal('document_number');

        if ($rawNumber === null || trim((string) $rawNumber) === '') {
            $stats['blank']++;

            return;
        }

        if (ApplicationDocument::documentNumberValueIsEncrypted($rawNumber)) {
            $stats['already_encrypted']++;

            return;
        }

        if (! $commit) {
            $stats['would_encrypt']++;

            return;
        }

        try {
            DB::table($document->getTable())
                ->where('id', $document->id)
                ->update([
                    'document_number' => ApplicationDocument::encryptDocumentNumberValue($rawNumber),
                ]);

            $stats['encrypted']++;
        } catch (Throwable $throwable) {
            $stats['failed']++;
            $this->error("Failed to encrypt document {$document->id}: {$throwable->getMessage()}");
        }
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
