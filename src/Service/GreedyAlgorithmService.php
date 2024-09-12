<?php

namespace App\Service;

use App\Entity\Developers;
use App\Entity\Jobs;

class GreedyAlgorithmService
{
public function __construct()
{
}
public function calculateBest(array $developers,array $jobs)
{
    $assignments = [];
    $jobsArr = [];
    foreach ($jobs as $job) {
        $jobsArr[] = [
            'id' => $job->getId(),
            'difficulty' => $job->getDifficulty(),
            'duration' => $job->getDuration(),
            'value' => $job->getDifficulty() / $job->getDuration() ,
        ];
    }

    usort($jobsArr, function ($a, $b) {
        return $a['value'] <=> $b['value'];
    });

    $numberOfChunks = count($developers);
    $chunks = iterator_to_array($this->array_chunk_generator($jobsArr, $numberOfChunks));

    foreach ($developers as $key => $developer) {
            $assignments[$developer->getName()][] = [
                'developerDegree' => $developer->getDegree(),
                'result' => $chunks[$key]
            ];
    }

    $total = 0.0;
    foreach ($assignments as $name => $chunk) {
        foreach ($chunk[0]['result'] as $chunkItem) {
            (float)$total += $chunkItem['difficulty'] / $chunk[0]['developerDegree'];
        }
    }

    return [
        'result' => $assignments,
        'total' =>$total
    ];
}

private function array_chunk_generator($array, $numberOfChunks) {
    $chunkSize = floor(count($array) / $numberOfChunks);
    for ($i = 0; $i < $numberOfChunks; $i++) {
        yield array_slice($array, $i * $chunkSize, $chunkSize);
    }
}
}