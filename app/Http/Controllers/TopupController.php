<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopTopupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index(Request $request)
    {
        // Search by user
        $search = $request->input('search');

        $topUsers = User::query()
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', "%$search%");
                })
                ->whereHas('topups', function ($query) {
                    $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                })
                ->withCount(['topups' => function ($query) {
                    $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                }])
                ->orderByDesc('topups_count')
                ->take(10)
                // ->paginate(2);
                ->get();

        $topUsers = $this->paginate($topUsers, $perPage = 2, $page = null, $options = ["path" => route('topup.index')]);
        // dd($topUsers);
        return view('topup.index', compact('topUsers'));
    }


    public function processTopTopupUsers()
    {
        // Find top topup users of the previous day
        $getTopUsers = User::query()
                ->whereHas('topups', function ($query) {
                        $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                })
                ->withCount(['topups' => function ($query) {
                        $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                }])
                ->orderByDesc('topups_count')
                ->take(10)
                ->get();
                // dd($getTopUsers);

        // Save top topup users to TopTopupUser table
        DB::transaction(function () use ($getTopUsers) {
            TopTopupUser::query()->delete();

            foreach ($getTopUsers as $user) {
                $data = new TopTopupUser();
                $data->user_id = $user->id;
                $data->count = $user->topups_count;
                $data->save();
            }
        });

        $topUsers = User::query()
                    ->with('topTopupUsers')
                    ->has('topTopupUsers')
                    // ->paginate(2);
                    ->get()
                    ->sortByDesc(function ($user) {
                        return $user->topTopupUsers->count;
                    })
                    ->values();

        $topUsers = $this->paginate($topUsers, $perPage = 2, $page = null, $options = ["path" => route('topup.process')]);
        // dd($topUsers);
        return view('topup.index', compact('topUsers'));
    }


    function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
