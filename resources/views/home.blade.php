@extends('layouts.master')

@section('style')

@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Тариф
            </div>
            <div class="card-body p-0 text-center">
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Огноо /Эхлэх/ </span></div>
                            <input class="custom-select" type="date" name='pdate2' id='pdate2' value="{{$date1}}"
                                   onchange="javascript:location.href = 'filter_tr_date/'+this.value;" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Аялал №</span></div>
                            <?php $text5 = ''; ?>
                            <select class="form-control" id="voyage1" name="voyage1" onchange="javascript:location.href = 'filter_tr_voyage/'+this.value;">
                                @foreach ($voyages1 as $item1)
                                    <option value="{{ $item1->voyage_id }}" @if($item1->voyage_id==$voyage1) selected <?php $text5 = $item1->train_no.' '.$item1->train_name_mn; ?> @endif>{{ $item1->train_no }} {{ $item1->train_name_mn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Явах</span></div>
                            <?php $text3 = ''; ?>
                            <select class="form-control" id="fr" name="fr" onchange="javascript:location.href = 'filter_tr_frstcode/'+this.value;">
                                @foreach ($frs as $frse)
                                    <option value="{{ $frse->station_code }}" @if($frse->station_code==$fr) selected <?php $text3 = $frse->station_code.' '.$frse->stop_name; ?> @endif>{{$frse->station_code }} {{ $frse->stop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Хүрэх</span></div>
                            <?php $text4 = ''; ?>
                            <select class="form-control" id="to" name="to" onchange="javascript:location.href = 'filter_tr_tostcode/'+this.value;">
                                @foreach ($tos as $tose)
                                    <option value="{{ $tose->station_code }}" @if($tose->station_code==$to) selected <?php $text3 = $tose->station_code.' '.$tose->stop_name; ?> @endif>{{$tose->station_code }} {{ $tose->stop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button onclick="printDiv('printableArea')" class="btn btn-success"><i class="fa fa-print"> </i>
                            Хэвлэх</button>
                    </div>
                </div>
                <div class="m-scrollable" data-scrollable="true" data-height="400">
                    <table class="table table-striped table-bordered" style="font-size: 12px">
                        <thead>
                        <tr role="row">
                            <th colspan="3">Гал тэрэг</th>
                            <th colspan="2">Явах</th>
                            <th colspan="2">Хүрэх</th>
                            <th>Зай</th>
                            <th colspan="5">Том хүн</th>
                            <th colspan="5">Хүүхэд</th>
                        </tr>
                        <tr role="row">
                            <th>#</th>
                            <th>№</th>
                            <th>Аялал</th>
                            <th>Код</th>
                            <th>Цаг</th>
                            <th>Код</th>
                            <th>Цаг</th>
                            <th>Км</th>
                            <th>Нийтийн</th>
                            <th>Унтлага</th>
                            <th>Тасалгаат</th>
                            <th>Ра-2 хатуу</th>
                            <th>Ра-2 зөөлөн</th>
                            <th>Нийтийн</th>
                            <th>Унтлага</th>
                            <th>Тасалгаат</th>
                            <th>Ра-2 хатуу</th>
                            <th>Ра-2 зөөлөн</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tar as $i=>$item)
                            <tr>
                                <td>{{date('Y-m-d', strtotime($item->dep_time))}}</td>
                                <td>{{ $item->train_no }} - {{ $item->wagon_name }} </td>
                                <td>{{ $item->train_name_mn }}</td>
                                <td>{{ $item->fromstcode}}-{{ $item->fromstname}}</td>
                                <td>{{date('H:i', strtotime($item->dep_time))}}</td>
                                <td>{{ $item->tostcode}} - {{$item->tostname}}</td>
                                <td>{{date('H:i', strtotime($item->arr_time))}}</td>
                                <td>{{ $item->km }}</td>
                                <td>{{ $item->niitiin }}</td>
                                <td>{{ $item->untlaga }}</td>
                                <td>{{ $item->tasalgaat }}</td>
                                <td>{{ $item->ra2_s }}</td>
                                <td>{{ $item->ra2_h }}</td>
                                <td>{{ $item->niitiin2 }}</td>
                                <td>{{ $item->untlaga2 }}</td>
                                <td>{{ $item->tasalgaat2 }}</td>
                                <td>{{ $item->ra2_s2 }}</td>
                                <td>{{ $item->ra2_h2 }}</td>
                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div><br>
        <div class="card">
            <div class="card-header">
                <b>Галт тэрэгний сул суудлын тайлан</b>
            </div>
            <div class="card-body p-0 text-center">
                <br>
                <div class="row">
                    <div class="col-md-3 offset-md-1">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Огноо /Эхлэх/ </span></div>
                            <input class="custom-select" type="date" name='pdate1' id='pdate1' value="{{$date}}"
                                   onchange="javascript:location.href = 'filter_free_mest_date/'+this.value;" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Аялал №</span></div>
                            <?php $text = ''; ?>
                            <select class="form-control" id="voyage" name="voyage" onchange="javascript:location.href = 'filter_free_mest_voyage/'+this.value;">
                                @foreach ($voyages as $item)
                                    <option value="{{ $item->voyage_id }}" @if($item->voyage_id==$voyage) selected <?php $text = $item->train_no.' '.$item->train_name_mn; ?> @endif>{{ $item->train_no }} {{ $item->train_name_mn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <button onclick="printDiv('printableArea')" class="btn btn-success"><i class="fa fa-print"> </i>
                            Хэвлэх</button>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12" id="printableArea">
                        @if($text)<span class="cashername"><b>Галт тэрэг: {{ $text }}</b></span><br>@endif
                        <span class="cashername"><b>Галт тэрэг явах огноо: {{ $date }}</b></span>
                        </span>
                        <table class="table" style="table-layout: fixed;font-size:12px;text-align:center;">
                            <thead class="table table-bordered" style="text-align:center; background-color: #c3ecd4; border-color: black">
                            <tr>
                                <th rowspan="2">№</th>
                                <th colspan="2">Вагон</th>
                                <th rowspan="2">Нийт суудлын тоо </th>
                                <th rowspan="2">Сул суудлын тоо </th>
                            </tr>
                            <tr>
                                <th>Дугаар</th>
                                <th>Төрөл</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sum = 0;?>
                            @foreach ($rep as $i=>$item)
                                <tr>
                                    <td rowspan="2">{{ $i+1 }}</td>
                                    <td>{{ $item->wagon_name }}</td>
                                    <td style="text-align: left;">{{ $item->wagontype_name }}</td>
                                    <td>{{ $item->totalmest }}</td>
                                    <td>{{ $item->free_count }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: left;">{{ $item->freemest }}</td>
                                </tr>
                                <?php $sum = $sum+$item->free_count;?>
                            @endforeach
                            <tr style="font-size:14px;">
                                <td></td>
                                <td colspan="2"><b> Нийт вагон тоо: {{ sizeof($rep) }}</b></td>
                                <td colspan="2"><b> Нийт сул суудал: {{ sizeof($rep) }}</b></td>
                            </tr>
                            </tbody>

                        </table>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            gettrain();
            $("#pdate1, #pdate2").change(function () {
                gettrain();
            });

            function gettrain() {
                var itag1 = $('#pdate1').val();
                var itag2 = $('#pdate2').val();
                $('#train_no').empty();
                $.get('gettrain/' + itag1 + '/' + itag2, function (data) {
                    $.each(data, function (i, qwe) {

                        $('#train_no').append($('<option>', {
                            value: qwe.train_no,
                            id: qwe.train_no,
                            text: qwe.train_no
                        })).trigger('change');

                        $('#train_no').focus();
                    });
                });
            }
        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>
@endsection