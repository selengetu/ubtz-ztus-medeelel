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
                <div class="m-scrollable" data-scrollable="true" data-height="400">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr role="row">
                            <th>#</th>
                            <th>Хураамж</th>
                            <th>Хөнгөлөлт %</th>

                        </tr>
                        </thead>
                        <tbody>

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
                </form>
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