<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class EmployeeController extends Controller
{
    protected array $dateFormats = [
        'Y-m-d',
        'Y-m-d H:i:s',
        'd.m.Y',
        'd.m.Y H:i',
        'd.m.Y H:i:s',
        'd/m/Y',
        'd-m-Y',
        'm/d/Y',
        'm-d-Y',
        'd.m.y',
        'm/d/y',
        'Y/m/d',
        'H:i',
        'H:i:s',
        'g:i A',
    ];

    public function index() {
        return view('welcome');
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:csv'
        ]);

        $filePath = $request->file('file')->getRealPath();
        $file = fopen($filePath, 'r');
        fgetcsv($file);

        $projects = [];

        while (($row = fgetcsv($file)) !== false) {
            $memberId   = trim($row[0]);
            $projectId  = trim($row[1]);
            $dateFrom   = $this->parseDate(trim($row[2]));
            $dateTo     = trim($row[3]);

            if(empty($dateTo) || strtolower($dateTo) == 'null') {
                $dateTo = Carbon::today();
            } else {
                $dateTo = $this->parseDate($dateTo);
            }

            if ($dateFrom != null && $dateTo != null) {
                $projects[$projectId][] = [
                    'memberId' => $memberId,
                    'from' => $dateFrom,
                    'to' => $dateTo
                ];
            }
        }
        fclose($file);
        $result = $this->findLongestWorkingPairs($projects);
        return response()->json($result);
    }

    protected function parseDate(string $dateString) {
        foreach ($this->dateFormats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString)->startOfDay();
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($dateString)->startOfDay();
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function findLongestWorkingPairs(array $projects) {
        $pairs = [];
        $pairsProjectDetails = [];

        foreach ($projects as $project => $members) {
            $count = count($members);

            for ($i = 0; $i < $count; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    $m1 = $members[$i];
                    $m2 = $members[$j];

                    if ($m1['memberId'] == $m2['memberId']) continue;

                    if ($m1['memberId'] < $m2['memberId']) {
                        $pair = $m1['memberId'] . '-' . $m2['memberId'];
                        $orderM1 = $m1['memberId'];
                        $orderM2 = $m2['memberId'];
                    } else {
                        $pair = $m2['memberId'] . '-' . $m1['memberId'];
                        $orderM1 = $m2['memberId'];
                        $orderM2 = $m1['memberId'];
                    }

                    $start = $m1['from']->max($m2['from']);
                    $end = $m1['to']->min($m2['to']);

                    if($start->lessThanOrEqualTo($end)) {
                        $days = $start->diffInDays($end) + 1;

                        if (!isset($pairs[$pair])) {
                            $pairs[$pair] = 0;
                        }

                        $pairs[$pair] += $days;

                        $pairsProjectDetails[$pair][] = [
                            'member1' => $orderM1,
                            'member2' => $orderM2,
                            'projectId' => $project,
                            'days' => $days,
                        ];
                    }
                }
            }
        }

        if (empty($pairs)) return [];

        $maxDays = -1;
        $pairKey = '';

        foreach ($pairs as $key => $sumDays) {
            if ($sumDays > $maxDays) {
                $maxDays = $sumDays;
                $pairKey = $key;
            }
        }
        if (isset($pairsProjectDetails[$pairKey])) return $pairsProjectDetails[$pairKey];
        return [];
    }
}
