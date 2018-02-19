<?php
    use ChristianEsperar\ProgrammersProverbsApi\ProgrammersProverbsApi;

    include_once(__DIR__ . '/../src/ProgrammersProverbsApi.php');

    $proverb = new ProgrammersProverbsApi();

    header('Content-type: application/json');

    echo json_encode([
        'data' => json_decode($proverb->getProverb('all'))
    ]);
