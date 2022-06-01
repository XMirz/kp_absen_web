<html>
{{-- @dd($monthlyStaffsPresences->first()->presences) --}}

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Styles -->
  {{--
  <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  <style>
    * {
      font-family: Times, "DejaVu Sans", sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100vw;
      font-size: 10;
    }

    table th,
    td {
      border-style: solid;
      border-color: rgb(0 0 0 0);
      border-width: 1px;
      padding: 0.25rem;
      white-space: nowrap;
    }

    td {
      text-align: center;
      font-family: DejaVu Sans, sans-serif;
    }


    td:nth-child(2) {
      text-align: left;
      font-family: Times, "DejaVu Sans", sans-serif;
    }

    td:nth-child(3) {
      text-align: left;
      font-family: Times, "DejaVu Sans", sans-serif;
    }
  </style>
</head>

<body>
  <div>
    <div>
      <div class="">
        <table class=" ">
          <thead>
            <tr>
              <th class="" scope="col" rowspan="2">
                No.
              </th>
              <th class="" scope="col" rowspan="2">
                Nama
              </th>🗸
              <th class="" scope="col" rowspan="2">
                Jabatan
              </th>
              <th class="" scope="col" colspan="{{$totalDaysInMonth}}">
                Tanggal
              </th>
            </tr>
            <tr>
              @foreach ($daysInMonth as $index=>$day)

              <th class="" scope="col">
                {{ $day["date"]->format('d') }}
              </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($monthlyStaffsPresences as $indexStaff=>$staff)

            <tr>
              <td class="" scope="col">{{ $indexStaff + 1 }}</td>
              <td class="" scope="col">
                {{ $staff->name }}
              </td>
              <td class="" scope="col">
                {{ $staff->roles->first()->title }}
              </td>
              @foreach ($daysInMonth as $indexDay=>$day)
              <td class="" scope="col">
                @if(count($staff->presences) > 0 && array_key_exists($indexDay+1, $staff->presences->toArray()))
                ✓
                @else
                {{-- NO --}}
                @endif
              </td>
              @endforeach
              {{-- endforeach day in month --}}
            </tr>

            @endforeach
            {{-- End loop monthlyStaffsPresences --}}
          </tbody>
        </table>
      </div>
    </div>
</body>

</html>
{{-- @dd() --}}