@extends('layoutCourse')
@push('css')
    <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="hoclythuyet type_flash_card type_do_new">
        @include('exam.lam_bai_moi')
        <section id="hoclythuyet" style="background: #35365e; min-height: 100vh;" class="clearfix flash_card">
            <div class="container">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8 pd5 box_do_learn"
                         style="background: #35365e">
                        <div class="ket-qua">
                            <div class="congratulation">
                                <P class="title"><strong>Chúc mừng bạn</strong></P>
                                <P class="title"><strong>VƯỢT QUA BÀI KIỂM TRA</strong></P>
                                <div class="row">
                                    <div class="col-md-6 score-1">
                                        <h1><strong class="score">10</strong></h1>
                                    </div>
                                    <div class="col-md-6 title-score">
                                        <h2><span class="score-text"><strong>Điểm</strong></span></h2>
                                        <span><strong class="minute-1">09:00 Phút</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="competition ">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><img width="28"
                                                 src="https://image.freepik.com/free-vector/businessman-character-avatar-icon-vector-illustration-design_24877-18271.jpg">&nbsp;<span>Nguyen DInh Nhu</span>
                                        </td>
                                        <td>100 Điểm</td>
                                        <td>90 phut</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<style type="text/css">
    .congratulation {
        padding-top: 30px;
        background: white;
        margin-top: 10px;
        border-radius: 5px;
    }

    .competition {
        color: white;
        margin-top: 10px;
        background: #9a7e52;
        border-radius: 5px;
    }

    .ket-qua {
        text-align: center;
    }

    .congratulation .title {
        font-size: 26px;
    }

    .title, .minute-1 {
        color: #35365e;
    }

    .score-1 {
        text-align: right;
        padding-right: 0;
    }

    .score {
        text-align: center;
        font-family: "Avant Garde", Avantgarde, "Century Gothic", CenturyGothic, "AppleGothic", sans-serif;
        font-size: 80px;
        height: 100px;
        padding-top: 40px;
        color: #ffc646;
        letter-spacing: .1em;
        text-shadow: 0 -1px 0 #fff, 0 1px 0 #f87b54, 0 2px 0 #f87b54, 0 3px 0 #f87b54, 0 4px 0 #f87b54, 0 5px 0 #f87b54, 0 6px 0 #f87b54
    }

    .score-text {
        color: #f87b54;
    }

    .title-score {
        text-align: left;
        height: 118px;
        vertical-align: middle;
        padding: 11px 0px;
    }
</style>