<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/argon-design-system-free@1.2.0/assets/css/argon-design-system.min.css">
</head>

<body class="bg-secondary">
    <div class="container">
        <div class="row my-5">
            @if ( session()->has('success'))
            <div class="alert alert-success">
                <p class="mb-0">
                    {{session('success')}}
                </p>
            </div>
            @endif
            <div class="col-12 col-md-12">
                <form action="" class="d-flex gap-3" method="POST">
                    @csrf
                    <input type="text" placeholder="About" name="about" class="btn btn-sm btn-dark">
                    <input type="text" placeholder="Price" name="price" class="btn btn-sm btn-dark">
                    <input type="date" name="date" class="btn btn-sm btn-dark">
                    <select name="type" class="btn btn-sm btn-dark">
                        <option value="in">Income</option>
                        <option value=" out">Outcome</option>
                    </select>
                    <input type="submit" value="Save" class="btn btn-success">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-body">
                    <ul class="list-group">
                        @foreach ($inouts as $inout)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h6>{{$inout->about}}</h6>
                                <small class="text-muted">{{$inout->date}}</small>
                            </div>
                            @if ($inout->type == 'in')
                            <span class=" text-success">
                                +{{$inout->price}}ks
                            </span>
                            @else
                            <span class=" text-danger">
                                -{{$inout->price}}ks
                            </span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between ">
                            <h5>Today Chart</h5>
                            <div>
                                <small class="text-success me-3">
                                    Income: +{{$income_mounts}}ks
                                </small>
                                <small class="text-danger">
                                    Outcome: -{{$outcome_mounts}}ks
                                </small>
                            </div>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: @json($days),
            datasets: [
                {
                    label: 'Income',
                    data: @json($income_total_mounts),
                    borderWidth: 1,
                    backgroundColor: '#26AF74'
                },
                {
                    label: 'Outcome',
                    data: @json($outcome_total_mounts),
                    borderWidth: 1,
                    backgroundColor: '#F9495C'
                }
            ]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    </script>
</body>

</html>