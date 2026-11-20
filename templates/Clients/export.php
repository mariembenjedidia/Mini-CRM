<?php
header('Content-Type: text/csv; charset=utf-8');

$output = fopen('php://output', 'w');

// BOM pour Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, ['ID', 'Entreprise', 'Contact', 'Email', 'Ville']);

foreach ($clients as $c) {
    fputcsv($output, [
        $c->id,
        $c->company_name,
        $c->contact_name,
        $c->email,
        $c->city,
    ]);
}

fclose($output);
?>