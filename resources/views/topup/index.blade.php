<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-kodemasom</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/bootstrap.min.css')}}"/>
    <script src="{{asset('assets/fontawesome/fontawesomepro.js')}}"></script>
</head>
<body>
    <div class="container my-3">
        <div class="bg-secondary text-white py-2 mb-5">
            <h5 class="text-center">Task - Kodemason</h5>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Top Topup Users
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('topup.index') }}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control"
                                    placeholder="Search by user">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table table-bordered table-hover table-responsive border-danger">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Topups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ optional($user->topTopupUsers)->count ?? 0 }}</td>
                        </tr>
                        @empty
                            <td colspan="100%" class="text-center text-danger">No Data Found!</td>
                        @endforelse
                    </tbody>
                </table>

                {{ $users->appends(request()->input())->links() }}

                <br>

                <form method="get" action="{{ route('topup.process') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Process Top Topup Users</button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
