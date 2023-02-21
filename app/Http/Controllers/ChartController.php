<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inout;

class ChartController extends Controller
{
    public function index()
    {
        $inouts = Inout::all();
        $today = date('Y-m-d');

        $mounts =  Inout::whereDate('date', $today)->get();
        $income_mounts = 0;
        $outcome_mounts = 0;
        foreach ($mounts as $mount) {
            if ($mount->type == 'in') {
                $income_mounts += $mount->price;
            } else {
                $outcome_mounts += $mount->price;
            }
        }

        return view('welcome', [
            'inouts'=>$inouts,
            'income_mounts'=>$income_mounts,
            'outcome_mounts'=>$outcome_mounts,
            'days'=>$this->calculator()['date_arr'],
            'income_total_mounts'=>$this->calculator()['income_total_mounts'],
            'outcome_total_mounts'=>$this->calculator()['outcome_total_mounts'],
        ]);
    }


    public function store(Request $request)
    {
        Inout::create([
            'about'=>$request->about,
            'price'=>$request->price,
            'date'=>$request->date,
            'type'=>$request->type,
        ]);

        return redirect()->back()->with('success', 'Income Successfully.');
    }

    public function calculator()
    {
        $days = [
            [
                'year'=>date('Y'),
                'month'=>date('m'),
                'day'=>date('d'),
            ]
        ];

        $date_arr = [date('D')];
        for ($i = 1;$i<=6;$i++) {
            $date_arr[] = date('D', strtotime("-$i day"));
            $new_date = [
                'year'=>date('Y', strtotime("-$i day")),
                'month'=>date('m', strtotime("-$i day")),
                'day'=>date('d', strtotime("-$i day")),
            ];
            $days[] = $new_date;
        }

        $income_total_mounts = [];
        $outcome_total_mounts = [];
        foreach ($days as $day) {
            $income_total_mounts [] = Inout::whereYear('date', $day['year'])->whereMonth('date', $day['month'])->whereDay('date', $day['day'])->where('type', 'in')->sum('price');
            $outcome_total_mounts[] = Inout::whereYear('date', $day['year'])->whereMonth('date', $day['month'])->whereDay('date', $day['day'])->where('type', 'out')->sum('price');
        }
        return ['date_arr'=>$date_arr,'income_total_mounts'=>$income_total_mounts,'outcome_total_mounts'=>$outcome_total_mounts];
    }
}
