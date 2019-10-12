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
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Явах</span></div>
                            <?php $text1 = ''; ?>
                            <select class="form-control" id="fr" name="fr" onchange="javascript:location.href = 'filter_tr_frstcode/'+this.value;">
                                @foreach ($frs as $frse)
                                    <option value="{{ $frse->st_id }}" @if($frse->st_id==$fr) selected <?php $text1 = $frse->st_name_mon; ?> @endif>{{ $frse->st_name_mon }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Хүрэх</span></div>
                            <?php $text2 = ''; ?>
                            <select class="form-control" id="to" name="to" onchange="javascript:location.href = 'filter_tr_tostcode/'+this.value;">
                                @foreach ($tos as $tose)
                                    <option value="{{ $tose->st_id }}" @if($tose->st_id==$to) selected <?php $text2 = $tose->st_name_mon; ?> @endif>{{ $tose->st_name_mon }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Огноо /Эхлэх/ </span></div>
                            <?php $text3 = ''; ?>
                            <select class="form-control" id="pdate2" name="pdate2" onchange="javascript:location.href = 'filter_tr_date/'+this.value;">
                                @foreach ($dates as $datess)
                                    <option value="{{ $datess->orderby }}" @if($datess->orderby ==$date1) selected <?php $text3 =$datess->orderby; ?> @endif>{{ $datess->orderby  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Аялал №</span></div>
                            <?php $text5 = ''; ?>
                            <select class="form-control" id="voyage1" name="voyage1" onchange="javascript:location.href = 'filter_tr_voyage/'+this.value;">
                                @foreach ($voyages1 as $item1)
                                    <option value="{{ $item1->voyage_id }}/{{ $item1->fvstop_id }}/{{ $item1->tvstop_id }}" @if($item1->voyage_id==$voyage1) selected <?php $text5 = $item1->train_no.' '.$item1->train_name_mn; ?> @endif>{{ $item1->train_no }} {{ $item1->train_name_mn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button onclick="printDiv('printableArea')" class="btn btn-success"><i class="fa fa-print"> </i>
                            Хэвлэх</button>
                    </div>
                </div>

                <div class="m-scrollable" data-scrollable="true" data-height="400" id="printableArea">
                    <center>
                        <b>
                    ЧИГЛЭЛ: {{$text1}} - {{$text2}}
                    <br>
                    ОГНОО: {{$text3}}
                    <br>
                    Аялал: {{$text5}}
                        </b>
                    </center>
                    <table class="table table-striped table-bordered" style="font-size: 12px">
                        <thead style="text-align:center; background-color: #c3ecd4; border-color: black">
                        <tr role="row">
                            <th>#</th>
                            <th>Төмөр зам</th>
                            <th>Вагон төрөл</th>
                            <th>Класс</th>
                            <th>Хавсралт</th>
                            <th>Том хүн</th>
                            <th>Хүүхэд (5-12)</th>
                            <th>Хүүхэд (0-12)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tar as $i=>$item)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $item->railway }} </td>
                                <td>{{ $item->wagontype_name }}</td>
                                <td>{{ $item->class_description }}</td>
                                <td>{{ $item->appendix}}</td>
                                <td>{{ $item->cost1}}</td>
                                <td>{{ $item->cost2}}</td>
                                <td>{{ $item->cost3}}</td>

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
                        <button onclick="printDiv('printableArea1')" class="btn btn-success"><i class="fa fa-print"> </i>
                            Хэвлэх</button>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12" id="printableArea1">
                        @if($text)<span class="cashername"><b>ГАЛТ ТЭРЭГ: {{ $text }}</b></span><br>@endif
                        <span class="cashername"><b>ГАЛТ ТЭРЭГ ЯВАХ ОГНОО: {{ $date }}</b></span>
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
            $("#pdate1").change(function () {
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