@extends('layouts.master')

@section('content')
    <section class="content-header"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">Огноо /Эхлэх/ </span></div>
                        <input class="custom-select" type="date" name='pdate1' id='pdate1' value="{{ $date }}"
                               onchange="javascript:location.href = 'filter_rep_vchd_date/'+this.value;" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">Аялал №</span></div>
                        <?php $text = ''; ?>
                        <select class="form-control" id="voyage" name="voyage" onchange="javascript:location.href = 'filter_rep_vchd_voyage/'+this.value;">
                            @foreach ($voyages as $item)
                                <option value="{{ $item->voyage_id }}" @if($item->voyage_id==$voyage) selected <?php $text = $item->train_no.' '.$item->train_name_mn; ?> @endif>{{ $item->train_no }} {{ $item->train_name_mn }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">Вагон №</span></div>
                        <?php $text1 = ''; ?>
                        <select class="form-control" id="wagon" name="wagon" onchange="javascript:location.href = 'filter_rep_vchd_wagon/'+this.value;">
                            <option value="0">Бүгд</option>
                            @foreach ($wagons as $wag)
                                <option value="{{ $wag->vwagon_id }}" @if($wag->vwagon_id==$wagon) selected <?php $text1 = $wag->wagon_name; ?> @endif>{{$wag->wagon_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button onclick="printDiv('printableArea')" class="btn btn-success"><i class="fa fa-print"> </i>
                        Хэвлэх</button>
                </div>
            </div>
            </form>
            <div class="row">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="m-scrollable" data-scrollable="true" data-height="400" id="printableArea">
                        <div class="col-md-12">
                            <br>
                            <h6 class="card-title" style="margin-left:35%;">Гал тэрэгний цай, цагаан хэрэглэлийн тайлан
                            </h6>
                            <span class="card-title" style="font-size:13px;">

                            @if($text)<span class="cashername">Галт тэрэг: {{ $text }}</span><br>@endif
                                @if($text1)<span class="vagonname">Вагон: {{ $text1 }}</span><br>@endif
                                <span class="cashername">Галт тэрэг явах огноо: {{ $date }}</span>
                        </span>
                            <table class="table" style="table-layout: fixed;font-size:12px;text-align:center;">
                                <thead class="table table-bordered" style="text-align:center;">
                                <tr>
                                    <th rowspan="2">№</th>
                                    @if($t == 1)

                                    <th rowspan="2">Вагон</th>
                                    <th rowspan="2">Суудлын тоо </th>
                                    @else
                                        <th rowspan="2">Мест дугаар </th>
                                    @endif
                                    <th colspan="2">Цай, сахар </th>
                                    <th colspan="2">Цагаан хэрэглэл </th>
                                    <th rowspan="2">Нийт орлого </th>
                                </tr>
                                <tr>
                                    <th>тоо</th>
                                    <th>орлого</th>
                                    <th>тоо</th>
                                    <th>орлого</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sum = 0;
                                $sumteacount = 0;
                                $sumteacost = 0;
                                $sumpastelcount = 0;
                                $sumpastelcost = 0;
                                $sumtotalcost = 0;


                                ?>
                                @if($t == 1)
                                @foreach ($rep as $i=>$item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->wagon_name }}</td>
                                        <td>{{ number_format($item->totalmest) }}</td>
                                        <td>{{ number_format($item->teacount) }}</td>
                                        <td>{{ number_format($item->teacost) }}</td>
                                        <td>{{ number_format($item->pastelcount) }}</td>
                                        <td>{{ number_format($item->pastelcost) }}</td>
                                        <td>{{ number_format($item->teacost+$item->pastelcost) }}</td>
                                    </tr>

                                    <?php $sumteacount = $sumteacount+$item->teacount;?>
                                    <?php $sumteacost = $sumteacost+$item->teacost;?>
                                    <?php $sumpastelcount = $sumpastelcount+$item->pastelcount;?>
                                    <?php $sumpastelcost = $sumpastelcost+$item->pastelcost;?>
                                    <?php $sumtotalcost = $sumtotalcost+$item->teacost+$item->pastelcost;?>
                                @endforeach
                                <tr style="font-size:14px;">
                                    <td colspan="3"><b>ДҮН</b></td>
                                    <td><b>{{number_format($sumteacount)}}</b></td>
                                    <td><b>{{number_format($sumteacost)}}</b></td>
                                    <td><b>{{number_format($sumpastelcount)}}</b></td>
                                    <td><b>{{number_format($sumpastelcost)}}</b></td>
                                    <td><b>{{number_format($sumtotalcost)}}</b></td>
                                </tr>

                                @elseif($t == 2)
                                    @foreach ($rep as $i=>$item)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $item->mest_no }}</td>
                                            <td>{{ number_format($item->teacount) }}</td>
                                            <td>{{ number_format($item->teacost) }}</td>
                                            <td>{{ number_format($item->pastelcount) }}</td>
                                            <td>{{ number_format($item->pastelcost) }}</td>
                                            <td>{{ number_format($item->teacost+$item->pastelcost) }}</td>
                                        </tr>

                                        <?php $sumteacount = $sumteacount+$item->teacount;?>
                                        <?php $sumteacost = $sumteacost+$item->teacost;?>
                                        <?php $sumpastelcount = $sumpastelcount+$item->pastelcount;?>
                                        <?php $sumpastelcost = $sumpastelcost+$item->pastelcost;?>
                                        <?php $sumtotalcost = $sumtotalcost+$item->teacost+$item->pastelcost;?>
                                    @endforeach
                                    <tr style="font-size:14px;">
                                        <td colspan="2"><b>ДҮН</b></td>
                                        <td><b>{{number_format($sumteacount)}}</b></td>
                                        <td><b>{{number_format($sumteacost)}}</b></td>
                                        <td><b>{{number_format($sumpastelcount)}}</b></td>
                                        <td><b>{{number_format($sumpastelcost)}}</b></td>
                                        <td><b>{{number_format($sumtotalcost)}}</b></td>
                                    </tr>

                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            gettrain();
            $("#pdate1, #pdate2").change(function () {
                gettrain();
            });
            $("#voyage").change(function () {
                getwagon();
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
            function getwagon() {
                var itag = $('#voyage').val();
                $('#wagon').append('<option value="0">Бүгд</option>');

                $.get('getwagon/' + itag1, function (data) {

                    $.each(data, function (i, qwe) {

                        $('#wagon').append($('<option>', {
                            value: qwe.vwagon_id,
                            id: qwe.vwagon_id,
                            text: qwe.wagon_name
                        })).trigger('change');

                        $('#wagon').focus();
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
