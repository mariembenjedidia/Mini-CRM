<?php
header('Content-Type: text/csv; charset=utf-8');

$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, ['ID', 'Prospect', 'Date appel', 'Sujet', 'Prochain appel', 'Créé le']);

foreach ($calls as $call) {
    fputcsv($output, [
        $call->id,
        $call->prospect->company_name ?? '',
        $call->call_date,
        $call->subject,
        $call->next_call_date,
        $call->created,
    ]);
}

fclose($output);
?>