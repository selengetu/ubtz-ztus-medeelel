@extends('layouts.master')

@section('style')
    <link href="{{ asset('css/wagon.css') }}" rel="stylesheet">
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
                            <?php $text6 = ''; ?>
                            <?php $text7 = ''; ?>

                            <select class="form-control" id="voyage1" name="voyage1" onchange="javascript:location.href = 'filter_tr_voyage/'+this.value;">
                                @foreach ($voyages1 as $item1)
                                    <option value="{{ $item1->voyage_id }}/{{ $item1->fvstop_id }}/{{ $item1->tvstop_id }}" @if($item1->voyage_id==$voyage1) selected <?php $text5 = $item1->train_no.' '.$item1->train_name_mn; ?><?php $text6 = $item1->fvstop_id; ?><?php $text7 = $item1->tvstop_id; ?>  @endif>{{ $item1->train_no }} {{ $item1->train_name_mn }}</option>
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
                <b>Галт тэрэгний сул суудал</b>
            </div>
            <div class="card-body p-0 text-center">
                <br>
                <div class="row" style="margin-top:-20px">
                    <div class="col" style="font-size:12px;">
                        <table id="wagonPercentagetable" class="table" >
                            <tbody><tr id="wagonName"><td>Вагон</td>@foreach ($wagons as $i=>$item)<td><a onclick="changeWagon({{ $item->vwagon_id }})">{{ $item->wagon_name }} {{ $item->wagontype_name }}</a></td> @endforeach</tr>
                            <tr id="wagonPercentage"><td>Дүүргэлт</td>
                                @foreach ($wagons as $i=>$item)

                                    <td><a onclick="changeWagon({{ $item->vwagon_id }})"><div class="progress"><div class="progress-bar
                                     @if(100*$item->filled/$item->totalmest<60)
                                                    bg-success

                 @elseif(100*$item->filled/$item->totalmest<80 && 100*$item->filled/$item->totalmest>60)

                                                    bg-warning

                   @elseif(100*$item->filled/$item->totalmest<101 && 100*$item->filled/$item->totalmest>80)
                                                    bg-danger
                    @endif
                                    progress-bar-success
                                     progress-bar-striped" role="progressbar" aria-valuenow="{{100*$item->filled/$item->totalmest}}" aria-valuemin="0" aria-valuemax="100" style="width:{{100*$item->filled/$item->totalmest}}%">{{$item->filled}}/{{$item->totalmest}}  </div></div></a></td>
                                @endforeach</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" style="margin-top:1rem;">
                    <div class="col-12" style="padding-left:1rem;">
                        <div class="myCanvas table-responsive">
                            <div class="wagon" id="wagonMain"><div class="wagon-start-container"><div class="wagon-start wagon-start-kupe"></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="2">2</button><button class="kupe-seat seat-inactive kupe-seat1" id="1">1</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="4" style="float: right;">4</button><button class="kupe-seat seat-inactive kupe-seat3" id="3" style="float: right;">3</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="6">6</button><button class="kupe-seat seat-inactive kupe-seat1" id="5">5</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-active kupe-seat4" id="8" style="float: right;">8</button><button class="kupe-seat seat-inactive kupe-seat3" id="7" style="float: right;">7</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-activated kupe-seat2" id="10">10</button><button class="kupe-seat seat-inactive kupe-seat1" id="9">9</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="12" style="float: right;">12</button><button class="kupe-seat seat-inactive kupe-seat3" id="11" style="float: right;">11</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="14">14</button><button class="kupe-seat seat-inactive kupe-seat1" id="13">13</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="16" style="float: right;">16</button><button class="kupe-seat seat-inactive kupe-seat3" id="15" style="float: right;">15</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="18">18</button><button class="kupe-seat seat-inactive kupe-seat1" id="17">17</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="20" style="float: right;">20</button><button class="kupe-seat seat-inactive kupe-seat3" id="19" style="float: right;">19</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="22">22</button><button class="kupe-seat seat-inactive kupe-seat1" id="21">21</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="24" style="float: right;">24</button><button class="kupe-seat seat-inactive kupe-seat3" id="23" style="float: right;">23</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="26">26</button><button class="kupe-seat seat-inactive kupe-seat1" id="25">25</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="28" style="float: right;">28</button><button class="kupe-seat seat-inactive kupe-seat3" id="27" style="float: right;">27</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="30">30</button><button class="kupe-seat seat-inactive kupe-seat1" id="29">29</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="32" style="float: right;">32</button><button class="kupe-seat seat-inactive kupe-seat3" id="31" style="float: right;">31</button></div></div></div><div class="wagon-room-container"><div class="wagon-room wagon-room-kupe"><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat2" id="34">34</button><button class="kupe-seat seat-inactive kupe-seat1" id="33">33</button></div><div class="wagon-side-kupe"><button class="kupe-seat seat-inactive kupe-seat4" id="36" style="float: right;">36</button><button class="kupe-seat seat-inactive kupe-seat3" id="35" style="float: right;">35</button></div></div></div><div class="wagon-end-container"><div class="wagon-end wagon-end-kupe"></div></div></div>
                        </div>
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

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function changeWagon(w) {

            let wid = w;
            let stop1 =  {{$fvstop_id}};
            let stop2 =  {{$tvstop_id}};
            let voyagesaleid=  0;
            console.log(stop1);

            console.log('getwagonmests/'+wid+'/'+stop1+'/'+stop2+'/'+voyagesaleid);
            $.get('getwagonmests/'+wid+'/'+stop1+'/'+stop2+'/'+voyagesaleid).done(function (data) {
                console.log(data);
                drawMests(data);
                $('#pleaseWaitDialog').modal('hide');
            });
        }
        //wagon onchange

        function drawMests(mests) {
            let container = $('#wagonMain');
            container.empty();
            //mestArray = [];
            console.log(mests.length);
            if (mests.length==36){
                container.append("<div class='wagon-start-container'><div class='wagon-start wagon-start-kupe'></div></div>");
                for (var i=0; i<9; i++){
                    container.append("<div class='wagon-room-container'><div class='wagon-room wagon-room-kupe'><div class='wagon-side-kupe'>"+
                        "<button class='mest kupe-seat "+getState(mests[parseInt(i*4+2-1)])+" kupe-seat2' id='"+parseInt(i*4+2)+"'                       >"+parseInt(i*4+2)+"</button>"+
                        "<button class='mest kupe-seat "+getState(mests[parseInt(i*4+1-1)])+" kupe-seat1' id='"+parseInt(i*4+1)+"'                       >"+parseInt(i*4+1)+"</button></div><div class='wagon-side-kupe'>"+
                        "<button class='mest kupe-seat "+getState(mests[parseInt(i*4+4-1)])+" kupe-seat4' id='"+parseInt(i*4+4)+"' style='float: right;' >"+parseInt(i*4+4)+"</button>"+
                        "<button class='mest kupe-seat "+getState(mests[parseInt(i*4+3-1)])+" kupe-seat3' id='"+parseInt(i*4+3)+"' style='float: right;' >"+parseInt(i*4+3)+"</button></div></div></div>");
                }
                container.append("<div class='wagon-end-container'><div class='wagon-end wagon-end-kupe'></div></div>");
            }
            else if (mests.length==54){
                container.append("<div class='wagon-start-container'><div class='wagon-start wagon-start-plat'></div></div>");
                for (var i=0; i<9; i++){
                    container.append("<div class='wagon-room-container'><div class='wagon-room wagon-room-plat'><div class='wagon-side-plat1 platskart'>"+
                        "<button class='mest plat-seat1 "+getState(mests[parseInt( i*4+2-1)])+" kupe-seat2' id='"+parseInt(i*4+2)+"'>"+parseInt(i*4+2)+"</button>"+
                        "<button class='mest plat-seat1 "+getState(mests[parseInt( i*4+1-1)])+" kupe-seat1' id='"+parseInt(i*4+1)+"'>"+parseInt(i*4+1)+"</button></div><div class='wagon-side-plat1 platskart'>"+
                        "<button class='mest plat-seat1 "+getState(mests[parseInt( i*4+4-1)])+" kupe-seat4' id='"+parseInt(i*4+4)+"'>"+parseInt(i*4+4)+"</button>"+
                        "<button class='mest plat-seat1 "+getState(mests[parseInt( i*4+3-1)])+" kupe-seat3' id='"+parseInt(i*4+3)+"'>"+parseInt(i*4+3)+"</button></div><div class='wagon-side-plat2 platskart'>"+
                        "<button class='mest plat-seat2 "+getState(mests[parseInt(54-i*2-2)])+" plat-seat-position1' id='"+parseInt(54-i*2-1)+"'>"+parseInt(54-i*2-1)+"</button>"+
                        "<button class='mest plat-seat2 "+getState(mests[parseInt(54-i*2-1)])+" plat-seat-position2' id='"+parseInt(54-i*2  )+"'>"+parseInt(54-i*2  )+"</button></div></div></div>");
                }
                container.append("<div class='wagon-end-container'><div class='wagon-end wagon-end-plat'></div></div>");
            }
            else if (mests.length==81){
                container.append("<div class='wagon-start-container'><div class='wagon-start wagon-start-plat'></div></div>");
                for (var i=0; i<9; i++){
                    container.append("<div class='wagon-room-container'><div class='wagon-room wagon-room-plat'><div class='wagon-side-plat1'>"+
                        "<div class='obsh-container1'><button class='mest obsh "+getState(mests[parseInt(i*6+3-1)])+"' id='"+parseInt(i*6+3)+"'>"+parseInt(i*6+3)+"</button></div>"+
                        "<div class='obsh-container1'><button class='mest obsh "+getState(mests[parseInt(i*6+2-1)])+"' id='"+parseInt(i*6+2)+"'>"+parseInt(i*6+2)+"</button></div>"+
                        "<div class='obsh-container1'><button class='mest obsh "+getState(mests[parseInt(i*6+1-1)])+"' id='"+parseInt(i*6+1)+"'>"+parseInt(i*6+1)+"</button></div></div>"+
                        "<div class='wagon-side-plat1'>"+
                        "<div class='obsh-container2'><button class='mest obsh "+getState(mests[parseInt(i*6+6-1)])+"' id='"+parseInt(i*6+6)+"'>"+parseInt(i*6+6)+"</button></div>"+
                        "<div class='obsh-container2'><button class='mest obsh "+getState(mests[parseInt(i*6+5-1)])+"' id='"+parseInt(i*6+5)+"'>"+parseInt(i*6+5)+"</button></div>"+
                        "<div class='obsh-container2'><button class='mest obsh "+getState(mests[parseInt(i*6+4-1)])+"' id='"+parseInt(i*6+4)+"'>"+parseInt(i*6+4)+"</button></div></div>"+
                        "<div class='wagon-side-plat2'>"+
                        "<div class='obsh-container3'><button class='mest obsh "+getState(mests[parseInt(81-i*3-1)])+"' id='"+parseInt(81-i*3  )+"'>"+parseInt(81-i*3  )+"</button></div>"+
                        "<div class='obsh-container3'><button class='mest obsh "+getState(mests[parseInt(81-i*3-2)])+"' id='"+parseInt(81-i*3-1)+"'>"+parseInt(81-i*3-1)+"</button></div>"+
                        "<div class='obsh-container3'><button class='mest obsh "+getState(mests[parseInt(81-i*3-3)])+"' id='"+parseInt(81-i*3-2)+"'>"+parseInt(81-i*3-2)+"</button></div></div></div></div>");
                }
                container.append("<div class='wagon-end-container'><div class='wagon-end wagon-end-plat'></div></div>");
            }
            else if (mests.length==18){
                container.append("<div class='wagon-start-container'><div class='wagon-start wagon-start-kupe'></div></div>");
                for (var i=0; i<9; i++){
                    container.append("<div class='wagon-room-container'><div class='wagon-room wagon-room-kupe'><div class='wagon-side-kupe'>"+
                        "<button class='mest lux-seat "+getState(mests[parseInt(i*2+1-1)])+" kupe-seat2' id='"+parseInt(i*2+1)+"'                       >"+parseInt(i*2+1)+"</button></div><div class='wagon-side-kupe'>"+
                        "<button class='mest lux-seat "+getState(mests[parseInt(i*2+2-1)])+" kupe-seat4' id='"+parseInt(i*2+2)+"' style='float: right;' >"+parseInt(i*2+2)+"</button></div></div></div>");
                }
                container.append("<div class='wagon-end-container'><div class='wagon-end wagon-end-kupe'></div></div>");
            }
            else {
                for (var i=0; i<mests.length; i++){
                    container.append(
                        "<button class='mest other-seat "+getState(mests[parseInt(i)])+"' id='"+parseInt(i+1)+"' >"+parseInt(i+1)+"</button>");
                }
            }
        }
        function getState(mest) {
            let message = 'seat-active'
            if (mest.mest_state!="0") {
                if (mest.mest_state=="1" && mest.order_pos_id=="1" && mest.order_uid=="1" && mest.sale_id==voyagesaleid) {
                    //mestArray.push(mest.mest_no);
                    message = 'seat-activated';
                    //updateNextButton();
                }
                else{
                    message = 'seat-inactive';
                }
            }
            /*else {
                mestArray.forEach(function(value, i) {
                    if(value==mest.mest_no) {
                        mestArray.splice(i, 1);
                        updateNextButton();
                    }
                });
            }
            $('#checkedmest').text(mestArray);*/
            return message;
        }
    </script>
@endsection