<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopTopupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index(Request $request)
    {
        // Search by user
        $search = $request->input('search');

        $users = User::query()
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', "%$search%");
                })
                ->with(['topTopupUsers' => function ($query) {
                        $query->orderByDesc('count');
                }])
                ->paginate(2);

        return view('topup.index', compact('users'));
    }


    public function processTopTopupUsers()
    {
        // Find top topup users of the previous day
        $topUsers = User::query()
                ->whereHas('topups', function ($query) {
                        $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                        // ->groupBy('user_id');
                        // ->selectRaw('user_id, sum(amount) as total_topup');
                        // $query->whereDate('created_at', Carbon::yesterday());
                })
                ->withCount(['topups' => function ($query) {
                        $query->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()]);
                }])
                ->orderByDesc('topups_count')
                ->take(10)
                ->get();

        // Save top topup users to TopTopupUser table
        DB::transaction(function () use ($topUsers) {
            TopTopupUser::query()->delete();

            foreach ($topUsers as $user) {
                TopTopupUser::create([
                        'user_id' => $user->id,
                        'count' => $user->topups_count,
                ]);
            }
        });

        return redirect()->route('topup.index')->with('success', 'Top topup users have been updated!');
    }

}
