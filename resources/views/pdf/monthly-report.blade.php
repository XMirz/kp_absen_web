<html>
{{-- @dd($monthlyStaffsPresences->first()->presences) --}}

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{$pageTitle ?? 'Rekap Absen'}}</title>
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
      /* font-size: 10; */
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
  <div class="flex flex-col space-y-4">
    <div class="text-center font">
      <h3 class="text-xl font-semibold">Rekapitulasi Presensi Pegawai</h3>
      <h3 class="text-2xl font-semibold">Hubungan Masyarakat dan Protokol Pimpimnan</h3>
      <h3 class="text-xl font-semibold">Sekretariat Daerah Kota Pekanbaru</h3>
    </div>
    <div class="flex flex-row gap-x-8 font-semibold">
      <div class="">
        <h6>Bulan</h6>
        <h6>Tahun</h6>
      </div>
      <div class="">
        <h6>: {{\Carbon\Carbon::createFromFormat('m', $month)->translatedFormat('F')}}</h6>
        <h6>: {{$year}}</h6>
      </div>
    </div>
    <table class="">
      <thead>
        <tr>
          <th class="!font-normal" scope="col" rowspan="2">
            No.
          </th>
          <th class="!font-normal" scope="col" rowspan="2">
            Nama
          </th>
          <th class="!font-normal" scope="col" rowspan="2">
            Jabatan
          </th>
          <th class="!font-normal" scope="col" colspan="{{$totalDaysInMonth}}">
            Tanggal
          </th>
        </tr>
        <tr>
          @foreach ($daysInMonth as $index=>$day)

          <th class="!font-normal"" scope=" col">
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
    <div class="flex justify-end mt-8">
      <div class="flex flex-col items-center justify-center">
        <h6>Pekanbaru, {{$day['date']->translatedFormat('d F Y')}}</h6>
        <h6>Kabag Prokopim</h6>
        <div class="h-12"></div>
        <h6>{{$chief->name}}</h6>
        <div class="w-16 h-1 bg-black"></div>
        <h6>{{$chief->nip}}</h6>
      </div>
    </div>
  </div>
</body>

</html>
{{-- @dd() --}}